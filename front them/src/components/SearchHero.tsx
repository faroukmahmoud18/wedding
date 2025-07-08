import { useState } from "react";
import { Search, MapPin, Calendar } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { ServiceCategory } from "@/types";
import { categoryConfig } from "@/data/sampleData";
import { FleurDeLis, RoyalCrown, RoyalOrnament, RoyalBorder } from "@/components/RoyalMotifs";

export function SearchHero() {
  const [searchQuery, setSearchQuery] = useState("");
  const [selectedCategory, setSelectedCategory] = useState<ServiceCategory | "all">("all");
  const [location, setLocation] = useState("");

  const handleSearch = () => {
    // TODO: Implement search functionality
    console.log({ searchQuery, selectedCategory, location });
  };

  return (
    <section className="relative bg-gradient-to-br from-ivory to-warm-ivory py-20 overflow-hidden">
      {/* Royal Background Pattern */}
      <div className="absolute inset-0 opacity-10">
        <div className="absolute top-10 left-10">
          <RoyalCrown className="text-primary" size={80} />
        </div>
        <div className="absolute top-20 right-20">
          <FleurDeLis className="text-primary" size={60} />
        </div>
        <div className="absolute bottom-20 left-20">
          <RoyalOrnament className="text-primary" size={100} />
        </div>
        <div className="absolute bottom-10 right-10">
          <FleurDeLis className="text-primary" size={70} />
        </div>
        <div className="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
          <RoyalOrnament className="text-primary" size={120} />
        </div>
      </div>
      
      <div className="container mx-auto px-4 sm:px-6 lg:px-8 relative">
        {/* Royal Crown Header */}
        <div className="text-center mb-12">
          <div className="flex justify-center mb-6">
            <RoyalCrown className="text-primary" size={48} />
          </div>
          <h1 className="font-serif text-4xl sm:text-5xl lg:text-6xl font-bold text-royal-deep-brown mb-6">
            Your Dream Wedding
            <span className="block text-royal-gradient">Starts Here</span>
          </h1>
          <p className="text-lg sm:text-xl text-muted-foreground max-w-2xl mx-auto">
            Discover premium wedding services from verified vendors. From photography to venues, 
            create your perfect royal wedding experience.
          </p>
          
          {/* Royal Border */}
          <div className="flex justify-center mt-8">
            <RoyalBorder className="text-primary" width={300} height={1} />
          </div>
        </div>

        {/* Search Form */}
        <div className="max-w-4xl mx-auto">
          <div className="bg-white rounded-2xl shadow-elegant p-6 sm:p-8">
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
              {/* Search Query */}
              <div className="relative">
                <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-muted-foreground" />
                <Input
                  placeholder="Search services..."
                  value={searchQuery}
                  onChange={(e) => setSearchQuery(e.target.value)}
                  className="pl-10 h-12"
                />
              </div>

              {/* Category */}
              <Select value={selectedCategory} onValueChange={(value) => setSelectedCategory(value as ServiceCategory | "all")}>
                <SelectTrigger className="h-12">
                  <SelectValue placeholder="All categories" />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem value="all">All categories</SelectItem>
                  {Object.entries(categoryConfig).map(([key, config]) => (
                    <SelectItem key={key} value={key}>
                      {config.icon} {config.title}
                    </SelectItem>
                  ))}
                </SelectContent>
              </Select>

              {/* Location */}
              <div className="relative">
                <MapPin className="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-muted-foreground" />
                <Input
                  placeholder="Location"
                  value={location}
                  onChange={(e) => setLocation(e.target.value)}
                  className="pl-10 h-12"
                />
              </div>

              {/* Search Button */}
              <Button 
                onClick={handleSearch}
                className="btn-royal h-12 text-base font-medium"
              >
                <Search className="h-5 w-5 mr-2" />
                Search
              </Button>
            </div>

            {/* Quick Categories */}
            <div className="mt-6 pt-6 border-t border-border">
              <p className="text-sm text-muted-foreground mb-3">Popular categories:</p>
              <div className="flex flex-wrap gap-2">
                {Object.entries(categoryConfig).map(([key, config]) => (
                  <Button
                    key={key}
                    variant="outline"
                    size="sm"
                    onClick={() => setSelectedCategory(key as ServiceCategory)}
                    className="hover:bg-primary hover:text-primary-foreground"
                  >
                    {config.icon} {config.title}
                  </Button>
                ))}
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}