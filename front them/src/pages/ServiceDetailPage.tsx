import { useState } from "react";
import { Layout } from "@/components/Layout";
import { useParams, Link } from "react-router-dom";
import { sampleServices, sampleVendors, categoryConfig } from "@/data/sampleData";
import { Service, Vendor, ServiceCategory } from "@/types";
import { RoyalOrnament, RoyalCrown, FleurDeLis, RoyalBorder } from "@/components/RoyalMotifs";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogTrigger, DialogDescription, DialogFooter, DialogClose } from "@/components/ui/dialog";
import { Sheet, SheetContent, SheetHeader, SheetTitle, SheetTrigger, SheetDescription, SheetFooter, SheetClose } from "@/components/ui/sheet";
import { BookingForm } from "@/components/forms/BookingForm";
import { Star, MapPin, Tag, CheckCircle, Heart, Share2, CalendarDays } from "lucide-react";
import { useQuery } from "@tanstack/react-query"; // For potential future API calls
import { useIsMobile } from "@/hooks/use-mobile";


// Simulate fetching data
const fetchServiceDetails = async (serviceId: string | undefined): Promise<Service | undefined> => {
  if (!serviceId) return undefined;
  // const response = await fetch(`/api/services/${serviceId}`);
  // const data = await response.json();
  // return data;
  return sampleServices.find(service => service.id === serviceId);
};

const fetchVendorDetails = async (vendorId: string | undefined): Promise<Vendor | undefined> => {
    if (!vendorId) return undefined;
    return sampleVendors.find(vendor => vendor.id === vendorId);
}


const ServiceDetailPage = () => {
  const { serviceId } = useParams<{ serviceId: string }>();
  const isMobile = useIsMobile();
  const [isBookingOpen, setIsBookingOpen] = useState(false);

  // Replace with React Query for actual data fetching
  // const { data: service, isLoading, error } = useQuery<Service | undefined, Error>(
  //   ['service', serviceId],
  //   () => fetchServiceDetails(serviceId),
  //   { enabled: !!serviceId }
  // );
  const service = sampleServices.find(s => s.id === serviceId);
  const vendor = service ? sampleVendors.find(v => v.id === service.vendorId) : undefined;
  const categoryDetails = service ? categoryConfig[service.category] : null;

  if (!service || !vendor || !categoryDetails) {
    return (
      <Layout>
        <div className="container mx-auto px-4 py-16 text-center">
          <RoyalOrnament className="text-primary opacity-50 mx-auto" size={60} />
          <h1 className="font-serif text-3xl font-bold text-royal-deep-brown mt-4">Service Not Found</h1>
          <p className="text-muted-foreground mt-4">The service you are looking for does not exist or is unavailable.</p>
          <Button asChild className="mt-8 btn-royal">
            <Link to="/">Go to Homepage</Link>
          </Button>
        </div>
      </Layout>
    );
  }

  const primaryImage = service.images.find(img => img.isPrimary) || service.images[0];
  const BookingComponent = isMobile ? Sheet : Dialog;
  const BookingTrigger = isMobile ? SheetTrigger : DialogTrigger;
  const BookingContent = isMobile ? SheetContent : DialogContent;
  const BookingHeader = isMobile ? SheetHeader : DialogHeader;
  const BookingTitle = isMobile ? SheetTitle : DialogTitle;
  const BookingDescription = isMobile ? SheetDescription : DialogDescription;
  const BookingFooter = isMobile ? SheetFooter : DialogFooter;
  const BookingClose = isMobile ? SheetClose : DialogClose;


  return (
    <Layout>
      <div className="container mx-auto px-2 sm:px-4 py-8">
        {/* Breadcrumbs (simplified) */}
        <nav className="mb-6 text-sm text-muted-foreground">
          <Link to="/" className="hover:text-primary">Home</Link> &gt;
          <Link to={`/services/${service.category}`} className="hover:text-primary"> {categoryDetails.title}</Link> &gt;
          <span className="font-medium text-foreground"> {service.title}</span>
        </nav>

        <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
          {/* Left Column: Image Gallery & Vendor Info */}
          <div className="lg:col-span-2 space-y-8">
            {/* Image Gallery */}
            <Card className="card-royal overflow-hidden">
              <CardContent className="p-0">
                <img
                  src={primaryImage?.path || '/api/placeholder/1200/800'}
                  alt={primaryImage?.alt || service.title}
                  className="w-full h-auto max-h-[600px] object-cover"
                />
                {/* TODO: Add carousel for multiple images if needed */}
                <div className="p-4 flex justify-end space-x-2">
                    <Button variant="outline" size="sm" className="hover-lift">
                        <Heart className="h-4 w-4 mr-2" /> Favorite
                    </Button>
                    <Button variant="outline" size="sm" className="hover-lift">
                        <Share2 className="h-4 w-4 mr-2" /> Share
                    </Button>
                </div>
              </CardContent>
            </Card>

            {/* Service Description */}
            <Card className="card-royal">
              <CardHeader className="relative">
                <CardTitle className="font-serif text-2xl text-royal-deep-brown">{service.title}</CardTitle>
                <div className="absolute top-4 right-4">
                    <FleurDeLis className="text-primary opacity-30" size={32} />
                </div>
              </CardHeader>
              <CardContent>
                <div className="flex items-center space-x-4 mb-4 text-sm text-muted-foreground">
                    <div className="flex items-center gap-1">
                        <Star className="h-4 w-4 fill-amber-400 text-amber-400" />
                        <span className="font-medium">{service.rating}</span>
                        <span>({service.reviewCount} reviews)</span>
                    </div>
                    <div className="flex items-center gap-1">
                        <MapPin className="h-4 w-4" />
                        <span>{service.location}</span>
                    </div>
                </div>
                <p className="text-foreground leading-relaxed whitespace-pre-line">{service.longDescription}</p>

                <div className="mt-6 pt-6 border-t border-border">
                  <h3 className="font-serif text-xl font-semibold text-royal-deep-brown mb-3">Key Features</h3>
                  <ul className="space-y-2">
                    {service.features.map((feature, index) => (
                      <li key={index} className="flex items-center text-foreground">
                        <CheckCircle className="h-5 w-5 text-primary mr-3 flex-shrink-0" />
                        <span>{feature}</span>
                      </li>
                    ))}
                  </ul>
                </div>
              </CardContent>
            </Card>

            {/* Vendor Information Card */}
            <Card className="card-royal">
              <CardHeader>
                <CardTitle className="font-serif text-xl text-royal-deep-brown">About the Vendor</CardTitle>
              </CardHeader>
              <CardContent>
                <div className="flex items-center mb-4">
                  {/* Placeholder for vendor logo */}
                  <div className="w-16 h-16 bg-muted rounded-full flex items-center justify-center mr-4">
                    <RoyalCrown className="text-primary" size={32} />
                  </div>
                  <div>
                    <Link to={`/vendors/${vendor.id}`} className="text-lg font-semibold text-primary hover:underline">{vendor.name}</Link>
                    {vendor.verified && <Badge variant="secondary" className="ml-2 text-xs">Verified Vendor</Badge>}
                  </div>
                </div>
                <p className="text-sm text-muted-foreground mb-3">{vendor.about}</p>
                <Button variant="outline" size="sm" asChild>
                  <Link to={`/vendors/${vendor.id}`}>View Vendor Profile</Link>
                </Button>
              </CardContent>
            </Card>
          </div>

          {/* Right Column: Booking & Price */}
          <div className="lg:col-span-1 space-y-8">
            <Card className="card-royal sticky top-24"> {/* Sticky for desktop */}
              <CardHeader className="relative">
                <CardTitle className="font-serif text-2xl text-royal-deep-brown">Book This Service</CardTitle>
                 <div className="absolute top-2 right-2">
                    <RoyalOrnament className="text-primary opacity-20" size={28} />
                </div>
              </CardHeader>
              <CardContent className="space-y-6">
                <div className="text-center">
                    <p className="text-sm text-muted-foreground">Starting from</p>
                    <p className="text-4xl font-bold text-primary my-1">
                    ${service.priceFrom.toLocaleString()}
                    {service.priceTo && <span className="text-2xl"> - ${service.priceTo.toLocaleString()}</span>}
                    </p>
                    <p className="text-sm text-muted-foreground">/ {service.unit}</p>
                </div>

                <div className="flex items-center text-sm text-muted-foreground">
                    <Tag className="h-4 w-4 mr-2 text-primary" />
                    <span>Category: <Link to={`/services/${service.category}`} className="text-primary hover:underline">{categoryDetails.title}</Link></span>
                </div>

                <BookingComponent open={isBookingOpen} onOpenChange={setIsBookingOpen}>
                  <BookingTrigger asChild>
                    <Button className="w-full btn-royal text-lg py-6">
                      <CalendarDays className="h-5 w-5 mr-2" />
                      Request Booking
                    </Button>
                  </BookingTrigger>
                  <BookingContent className={isMobile ? "w-full" : "sm:max-w-[525px]"}>
                    <BookingHeader>
                      <BookingTitle className="font-serif text-2xl text-royal-deep-brown flex items-center">
                        <RoyalCrown className="text-primary mr-2 h-6 w-6" />
                        Book: {service.title}
                      </BookingTitle>
                      <BookingDescription>
                        Fill in your details below to request a booking. The vendor will contact you to confirm availability and details.
                      </BookingDescription>
                    </BookingHeader>

                    <div className="py-4">
                      <BookingForm service={service} onSubmitSuccess={() => setIsBookingOpen(false)} />
                    </div>

                    {!isMobile && (
                        <BookingFooter>
                            <BookingClose asChild>
                                <Button variant="outline">Cancel</Button>
                            </BookingClose>
                        </BookingFooter>
                    )}
                  </BookingContent>
                </BookingComponent>

                <p className="text-xs text-muted-foreground text-center">
                  Submitting this form does not guarantee booking. The vendor will confirm availability.
                </p>
                 <div className="flex justify-center mt-4">
                    <RoyalBorder className="text-primary" width={100} height={0.5} />
                </div>
              </CardContent>
            </Card>
          </div>
        </div>
      </div>
    </Layout>
  );
};

export default ServiceDetailPage;
