<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Vendor;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $category_id = $request->input('category_id');
        $location = $request->input('location');
        $min_price = $request->input('min_price');
        $max_price = $request->input('max_price');
        $sort_by = $request->input('sort_by', 'relevance'); // e.g., relevance, price_asc, price_desc, new_first

        $servicesQuery = Service::query()->with(['vendor', 'category', 'images', 'reviews'])
            ->where('status', 'approved') // Only show approved services
            ->where('is_live', true); // Only show live services

        if ($query) {
            $servicesQuery->where(function (Builder $q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%")
                  ->orWhere('tags', 'LIKE', "%{$query}%") // Assumes tags are stored as JSON array or comma-separated string
                  ->orWhereHas('vendor', function (Builder $q_vendor) use ($query) {
                      $q_vendor->where('name', 'LIKE', "%{$query}%");
                  })
                  ->orWhereHas('category', function (Builder $q_category) use ($query) {
                      $q_category->where('name', 'LIKE', "%{$query}%");
                  });
            });
        }

        if ($category_id) {
            $servicesQuery->where('category_id', $category_id);
        }

        if ($location) {
            // Basic location search. For more advanced, consider dedicated spatial indexes or services.
            $servicesQuery->where('location_text', 'LIKE', "%{$location}%");
        }

        if ($min_price) {
            $servicesQuery->where('price', '>=', $min_price);
        }

        if ($max_price) {
            $servicesQuery->where('price', '<=', $max_price);
        }

        switch ($sort_by) {
            case 'price_asc':
                $servicesQuery->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $servicesQuery->orderBy('price', 'desc');
                break;
            case 'new_first':
                $servicesQuery->orderBy('created_at', 'desc');
                break;
            // Add more sorting options as needed, e.g., by rating
            case 'relevance':
            default:
                // Basic relevance: prioritize title matches, then description, then others.
                // This is a simple implementation. True relevance scoring is complex.
                if ($query) {
                    $servicesQuery->orderByRaw("
                        CASE
                            WHEN title LIKE ? THEN 1
                            WHEN description LIKE ? THEN 2
                            WHEN tags LIKE ? THEN 3
                            WHEN EXISTS (SELECT 1 FROM vendors WHERE services.vendor_id = vendors.id AND vendors.name LIKE ?) THEN 4
                            WHEN EXISTS (SELECT 1 FROM categories WHERE services.category_id = categories.id AND categories.name LIKE ?) THEN 5
                            ELSE 6
                        END ASC
                    ", ["%{$query}%", "%{$query}%", "%{$query}%", "%{$query}%", "%{$query}%"]);
                }
                $servicesQuery->orderBy('created_at', 'desc'); // Fallback sort
                break;
        }

        $services = $servicesQuery->paginate(15); // Paginate results

        $categories = Category::orderBy('name')->get();
        // Potentially get distinct locations for filter dropdown, if feasible
        // $locations = Service::where('status', 'approved')->where('is_live', true)->distinct()->pluck('location_text')->filter()->sort();


        return view('search.results', compact('services', 'categories', 'query', 'category_id', 'location', 'min_price', 'max_price', 'sort_by'));
    }
}
