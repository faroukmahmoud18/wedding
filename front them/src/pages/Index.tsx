import { Layout } from "@/components/Layout";
import { SearchHero } from "@/components/SearchHero";
import { ServiceCard } from "@/components/ServiceCard";
import { CategoryCard } from "@/components/CategoryCard";
import { sampleServices, categoryConfig } from "@/data/sampleData";
import { ServiceCategory } from "@/types";
import { Button } from "@/components/ui/button";
import { ArrowRight, Shield, Heart, Award } from "lucide-react";
import { RoyalCrown, FleurDeLis, RoyalOrnament, RoyalBorder } from "@/components/RoyalMotifs";

const Index = () => {
  const featuredServices = sampleServices.filter(service => service.featured);
  const categories = Object.keys(categoryConfig) as ServiceCategory[];

  return (
    <Layout>
      {/* Hero Section */}
      <SearchHero />

      {/* Features Section */}
      <section className="py-16 bg-warm-ivory/50 relative">
        {/* Royal Section Header */}
        <div className="absolute top-8 left-1/2 transform -translate-x-1/2">
          <RoyalOrnament className="text-primary" size={32} />
        </div>
        <div className="container mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-12">
            <div className="flex justify-center mb-4">
              <RoyalBorder className="text-primary" width={200} height={1} />
            </div>
            <h2 className="font-serif text-3xl sm:text-4xl font-bold text-royal-deep-brown mb-4">
              Why Choose Royal Vows?
            </h2>
            <p className="text-lg text-muted-foreground max-w-2xl mx-auto">
              We connect you with the finest wedding vendors, ensuring your special day is nothing short of extraordinary.
            </p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div className="text-center">
              <div className="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4 relative">
                <Shield className="h-8 w-8 text-primary" />
                <div className="absolute -top-2 -right-2">
                  <FleurDeLis className="h-4 w-4 text-primary" />
                </div>
              </div>
              <h3 className="font-serif text-xl font-semibold mb-2">Verified Vendors</h3>
              <p className="text-muted-foreground">
                All our vendors are thoroughly vetted and verified to ensure the highest quality of service.
              </p>
            </div>

            <div className="text-center">
              <div className="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                <Heart className="h-8 w-8 text-primary" />
              </div>
              <h3 className="font-serif text-xl font-semibold mb-2">Personalized Service</h3>
              <p className="text-muted-foreground">
                Receive tailored recommendations and dedicated support throughout your wedding planning journey.
              </p>
            </div>

            <div className="text-center">
              <div className="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                <Award className="h-8 w-8 text-primary" />
              </div>
              <h3 className="font-serif text-xl font-semibold mb-2">Award-Winning</h3>
              <p className="text-muted-foreground">
                Our platform and vendors have received numerous awards for excellence in wedding services.
              </p>
            </div>
          </div>
        </div>
      </section>

      {/* Categories Section */}
      <section className="py-16 relative">
        <div className="absolute top-8 left-1/2 transform -translate-x-1/2">
          <RoyalCrown className="text-primary" size={32} />
        </div>
        <div className="container mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-12">
            <h2 className="font-serif text-3xl sm:text-4xl font-bold text-royal-deep-brown mb-4">
              Wedding Service Categories
            </h2>
            <p className="text-lg text-muted-foreground max-w-2xl mx-auto">
              Explore our comprehensive range of wedding services, from photography to venues.
            </p>
          </div>

          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {categories.map((category) => (
              <CategoryCard
                key={category}
                category={category}
                serviceCount={sampleServices.filter(s => s.category === category).length}
              />
            ))}
          </div>
        </div>
      </section>

      {/* Featured Services */}
      <section className="py-16 bg-warm-ivory/50 relative">
        <div className="absolute top-8 left-1/2 transform -translate-x-1/2">
          <FleurDeLis className="text-primary" size={32} />
        </div>
        <div className="container mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex items-center justify-between mb-12">
            <div>
              <h2 className="font-serif text-3xl sm:text-4xl font-bold text-royal-deep-brown mb-4">
                Featured Services
              </h2>
              <p className="text-lg text-muted-foreground">
                Discover our handpicked premium wedding services from top-rated vendors.
              </p>
            </div>
            <Button variant="outline" className="hidden md:flex items-center">
              View All Services
              <ArrowRight className="h-4 w-4 ml-2" />
            </Button>
          </div>

          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            {featuredServices.map((service) => (
              <ServiceCard key={service.id} service={service} />
            ))}
          </div>

          <div className="text-center mt-8 md:hidden">
            <Button variant="outline" className="w-full sm:w-auto">
              View All Services
              <ArrowRight className="h-4 w-4 ml-2" />
            </Button>
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="py-16 bg-gradient-to-r from-primary to-primary/90 text-primary-foreground relative overflow-hidden">
        {/* Royal decorations */}
        <div className="absolute top-10 left-10 opacity-20">
          <RoyalOrnament className="text-white" size={60} />
        </div>
        <div className="absolute bottom-10 right-10 opacity-20">
          <RoyalCrown className="text-white" size={80} />
        </div>
        <div className="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="font-serif text-3xl sm:text-4xl font-bold mb-4">
            Ready to Plan Your Dream Wedding?
          </h2>
          <p className="text-lg opacity-90 mb-8 max-w-2xl mx-auto">
            Join thousands of couples who found their perfect wedding vendors through Royal Vows. 
            Start your journey today.
          </p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <Button size="lg" variant="outline" className="bg-white text-primary hover:bg-white/90">
              Browse All Services
            </Button>
            <Button size="lg" variant="outline" className="border-white text-white hover:bg-white hover:text-primary">
              Become a Vendor
            </Button>
          </div>
        </div>
      </section>
    </Layout>
  );
};

export default Index;
