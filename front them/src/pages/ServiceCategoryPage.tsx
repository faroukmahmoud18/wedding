import { Layout } from "@/components/Layout";
import { useParams, Link } from "react-router-dom";
import { sampleServices, categoryConfig } from "@/data/sampleData";
import { ServiceCard } from "@/components/ServiceCard";
import { ServiceCategory, Service } from "@/types";
import { RoyalOrnament, RoyalBorder } from "@/components/RoyalMotifs";
import { Button } from "@/components/ui/button";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Input } from "@/components/ui/input";
import { Slider } from "@/components/ui/slider";
import { Star } from "lucide-react";
import { useQuery } from "@tanstack/react-query"; // For potential future API calls

// Simulate fetching data (replace with actual API call via React Query later)
const fetchServicesByCategory = async (categorySlug: string | undefined): Promise<Service[]> => {
  if (!categorySlug) return [];
  // In a real app, this would be an API call:
  // const response = await fetch(`/api/services?category=${categorySlug}`);
  // const data = await response.json();
  // return data;
  return sampleServices.filter(service => service.category === categorySlug as ServiceCategory);
};


const ServiceCategoryPage = () => {
  const { categorySlug } = useParams<{ categorySlug: string }>();

  // In a real app, use React Query like this:
  // const { data: services, isLoading, error } = useQuery<Service[], Error>(
  //   ['services', categorySlug],
  //   () => fetchServicesByCategory(categorySlug),
  //   { enabled: !!categorySlug }
  // );
  // For now, using synchronous filtering from sampleData
  const services = sampleServices.filter(
    (service) => service.category === (categorySlug as ServiceCategory)
  );
  const categoryDetails = categorySlug ? categoryConfig[categorySlug as ServiceCategory] : null;

  // Placeholder states for filters - functionality not fully implemented
  // const [sortBy, setSortBy] = useState("popularity");
  // const [priceRange, setPriceRange] = useState([0, 10000]);
  // const [minRating, setMinRating] = useState(0);

  if (!categoryDetails) {
    return (
      <Layout>
        <div className="container mx-auto px-4 py-16 text-center">
          <h1 className="font-serif text-3xl font-bold text-royal-deep-brown">Category Not Found</h1>
          <p className="text-muted-foreground mt-4">The category "{categorySlug}" does not exist.</p>
          <Button asChild className="mt-8 btn-royal">
            <Link to="/">Go to Homepage</Link>
          </Button>
        </div>
      </Layout>
    );
  }

  return (
    <Layout>
      <div className="container mx-auto px-4 py-8">
        {/* Page Header */}
        <div className="text-center mb-12">
          <div className="flex justify-center mb-4">
            <span className="text-6xl opacity-80">{categoryDetails.icon}</span>
          </div>
          <h1 className="font-serif text-4xl sm:text-5xl font-bold text-royal-deep-brown mb-4">
            {categoryDetails.title}
          </h1>
          <p className="text-lg text-muted-foreground max-w-2xl mx-auto">
            {categoryDetails.description}
          </p>
          <div className="flex justify-center mt-6">
            <RoyalBorder className="text-primary" width={200} height={1} />
          </div>
        </div>

        {/* Filters - Basic UI, no full functionality yet */}
        <div className="mb-12 p-6 bg-card rounded-xl shadow-elegant">
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 items-end">
            <div>
              <label htmlFor="sort" className="block text-sm font-medium text-muted-foreground mb-1">Sort by</label>
              <Select defaultValue="popularity" onValueChange={(value) => console.log(value)}>
                <SelectTrigger id="sort">
                  <SelectValue placeholder="Sort by..." />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem value="popularity">Popularity</SelectItem>
                  <SelectItem value="price_asc">Price: Low to High</SelectItem>
                  <SelectItem value="price_desc">Price: High to Low</SelectItem>
                  <SelectItem value="rating">Rating</SelectItem>
                </SelectContent>
              </Select>
            </div>
            <div>
              <label htmlFor="price" className="block text-sm font-medium text-muted-foreground mb-1">Price Range ($)</label>
              {/* For a real implementation, use a range slider or two inputs */}
              <div className="flex items-center gap-2">
                <Input type="number" placeholder="Min" className="w-1/2" defaultValue={0} />
                <Input type="number" placeholder="Max" className="w-1/2" defaultValue={10000} />
              </div>
              {/* <Slider defaultValue={[0, 10000]} max={20000} step={100} className="mt-2" onValueChange={(value) => console.log(value)} /> */}
            </div>
            <div>
              <label htmlFor="rating" className="block text-sm font-medium text-muted-foreground mb-1">Minimum Rating</label>
              <Select defaultValue="0" onValueChange={(value) => console.log(value)}>
                <SelectTrigger id="rating">
                  <SelectValue placeholder="Any Rating" />
                </SelectTrigger>
                <SelectContent>
                  {[0,1,2,3,4,5].map(r => (
                    <SelectItem key={r} value={String(r)}>
                      {r === 0 ? "Any Rating" : <>{Array(r).fill(0).map((_,i)=><Star key={i} className="inline h-4 w-4 fill-amber-400 text-amber-400" />)} & Up</>}
                    </SelectItem>
                  ))}
                </SelectContent>
              </Select>
            </div>
            <Button className="btn-royal h-10">Apply Filters</Button>
          </div>
        </div>

        {/* Service Listing */}
        {services.length > 0 ? (
          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            {services.map((service) => (
              <ServiceCard key={service.id} service={service} />
            ))}
          </div>
        ) : (
          <div className="text-center py-12">
            <RoyalOrnament className="text-primary opacity-50 mx-auto" size={60} />
            <p className="mt-4 text-xl text-muted-foreground">
              No services found in this category yet.
            </p>
            <Button asChild className="mt-8 btn-royal">
              <Link to="/">Explore Other Categories</Link>
            </Button>
          </div>
        )}
      </div>
    </Layout>
  );
};

export default ServiceCategoryPage;
