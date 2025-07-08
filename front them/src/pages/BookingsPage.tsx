import { Layout } from "@/components/Layout";
import { Link } from "react-router-dom";
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import { RoyalOrnament, FleurDeLis, RoyalBorder } from "@/components/RoyalMotifs";
import { sampleServices, sampleVendors } from "@/data/sampleData"; // Using sample data for placeholder
import { Booking, Service, Vendor } from "@/types"; // Assuming Booking type exists
import { CalendarDays, MapPin, AlertTriangle, CheckCircle, Hourglass, XCircle } from "lucide-react";

// Placeholder for actual bookings data - this would come from user state or API
const userBookings: Booking[] = [
  {
    id: "booking1",
    serviceId: sampleServices[0].id,
    service: sampleServices[0],
    userId: "user123", // Placeholder user ID
    eventDate: "2024-12-15T14:00:00Z",
    quantity: 1,
    total: sampleServices[0].priceFrom,
    status: "confirmed",
    notes: "Evening event, need good lighting.",
    createdAt: "2024-07-01T10:00:00Z",
  },
  {
    id: "booking2",
    serviceId: sampleServices[2].id,
    service: sampleServices[2],
    userId: "user123",
    eventDate: "2025-02-10T10:00:00Z",
    quantity: 1,
    total: sampleServices[2].priceFrom,
    status: "pending",
    createdAt: "2024-07-15T12:30:00Z",
  },
  {
    id: "booking3",
    serviceId: sampleServices[3].id,
    service: sampleServices[3],
    userId: "user123",
    eventDate: "2024-08-20T09:00:00Z",
    quantity: 1,
    total: sampleServices[3].priceFrom,
    status: "cancelled",
    notes: "Changed wedding theme.",
    createdAt: "2024-06-20T15:00:00Z",
  },
];


const getStatusProps = (status: Booking['status']) => {
    switch (status) {
        case 'confirmed':
            return { icon: <CheckCircle className="h-4 w-4 mr-2 text-green-600" />, text: "Confirmed", color: "bg-green-100 text-green-700 border-green-300" };
        case 'pending':
            return { icon: <Hourglass className="h-4 w-4 mr-2 text-amber-600" />, text: "Pending Confirmation", color: "bg-amber-100 text-amber-700 border-amber-300" };
        case 'cancelled':
            return { icon: <XCircle className="h-4 w-4 mr-2 text-red-600" />, text: "Cancelled", color: "bg-red-100 text-red-700 border-red-300" };
        default:
            return { icon: <AlertTriangle className="h-4 w-4 mr-2 text-gray-600" />, text: "Unknown Status", color: "bg-gray-100 text-gray-700 border-gray-300" };
    }
};


const BookingsPage = () => {
  // In a real app, fetch bookings for the logged-in user via React Query
  // const { data: bookings, isLoading, error } = useQuery...

  const activeBookings = userBookings.filter(b => b.status === 'pending' || b.status === 'confirmed');
  const pastBookings = userBookings.filter(b => b.status === 'completed' || b.status === 'cancelled');


  return (
    <Layout>
      <div className="container mx-auto px-4 py-8">
        <div className="text-center mb-12">
          <div className="flex justify-center mb-6">
            <RoyalOrnament className="text-primary" size={48} />
          </div>
          <h1 className="font-serif text-4xl sm:text-5xl font-bold text-royal-deep-brown mb-4">
            My Royal Bookings
          </h1>
          <p className="text-lg text-muted-foreground max-w-2xl mx-auto">
            Review your scheduled services, manage your upcoming appointments, and view past engagements.
          </p>
           <div className="flex justify-center mt-6">
            <RoyalBorder className="text-primary" width={200} height={1} />
          </div>
        </div>

        {userBookings.length === 0 ? (
          <div className="text-center py-16">
            <FleurDeLis className="text-primary opacity-30 mx-auto" size={80} />
            <h2 className="font-serif text-2xl text-royal-deep-brown mt-6 mb-3">No Bookings Yet</h2>
            <p className="text-muted-foreground mb-6">
              You haven't booked any royal services yet. It's time to plan your majestic event!
            </p>
            <Button asChild size="lg" className="btn-royal">
              <Link to="/">Explore Services</Link>
            </Button>
          </div>
        ) : (
          <div className="space-y-10">
            {activeBookings.length > 0 && (
              <section>
                <h2 className="font-serif text-2xl sm:text-3xl font-semibold text-royal-deep-brown mb-6 flex items-center">
                  <CalendarDays className="h-7 w-7 mr-3 text-primary" /> Upcoming & Pending Bookings
                </h2>
                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                  {activeBookings.map((booking) => {
                    const statusProps = getStatusProps(booking.status);
                    const serviceImage = booking.service.images.find(img => img.isPrimary) || booking.service.images[0];
                    return (
                      <Card key={booking.id} className="card-royal hover-lift overflow-hidden">
                        <div className="flex flex-col sm:flex-row">
                            <div className="sm:w-1/3 h-48 sm:h-auto overflow-hidden">
                                <img
                                    src={serviceImage?.path || '/api/placeholder/300/300'}
                                    alt={booking.service.title}
                                    className="w-full h-full object-cover"
                                />
                            </div>
                            <div className="sm:w-2/3">
                                <CardHeader className="pb-3">
                                <div className="flex justify-between items-start">
                                    <CardTitle className="font-serif text-xl text-royal-deep-brown line-clamp-2">
                                        <Link to={`/services/${booking.service.category}/${booking.service.id}`} className="hover:text-primary">
                                        {booking.service.title}
                                        </Link>
                                    </CardTitle>
                                    <Badge variant="outline" className={statusProps.color}>
                                        {statusProps.icon} {statusProps.text}
                                    </Badge>
                                </div>
                                <CardDescription className="text-xs">
                                    By <Link to={`/vendors/${booking.service.vendor.id}`} className="text-primary hover:underline">{booking.service.vendor.name}</Link>
                                </CardDescription>
                                </CardHeader>
                                <CardContent className="space-y-2 text-sm pt-0 pb-3">
                                <div className="flex items-center text-muted-foreground">
                                    <CalendarDays className="h-4 w-4 mr-2 text-primary" />
                                    <span>Event Date: {new Date(booking.eventDate).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}</span>
                                </div>
                                <div className="flex items-center text-muted-foreground">
                                    <MapPin className="h-4 w-4 mr-2 text-primary" />
                                    <span>{booking.service.location}</span>
                                </div>
                                {booking.notes && <p className="text-xs italic text-muted-foreground pt-1">Your notes: "{booking.notes}"</p>}
                                </CardContent>
                                <CardFooter className="flex justify-end space-x-2 pb-3 pr-3">
                                    <Button variant="outline" size="sm">View Details</Button>
                                    {booking.status === 'pending' && <Button variant="destructive" size="sm" className="btn-royal-outline">Cancel Request</Button>}
                                    {booking.status === 'confirmed' && <Button variant="outline" size="sm">Reschedule</Button>}
                                </CardFooter>
                            </div>
                        </div>
                      </Card>
                    );
                  })}
                </div>
              </section>
            )}

            {pastBookings.length > 0 && (
                 <section>
                    <h2 className="font-serif text-2xl sm:text-3xl font-semibold text-royal-deep-brown mb-6 pt-6 border-t border-border flex items-center">
                        <FleurDeLis className="h-6 w-6 mr-3 text-primary" /> Past Bookings
                    </h2>
                    <div className="space-y-4">
                        {pastBookings.map((booking) => {
                             const statusProps = getStatusProps(booking.status);
                             return (
                                <Card key={booking.id} className="card-royal opacity-80">
                                    <CardHeader className="flex flex-row justify-between items-center p-4">
                                        <div>
                                            <CardTitle className="font-serif text-lg text-muted-foreground">
                                                <Link to={`/services/${booking.service.category}/${booking.service.id}`} className="hover:text-primary">
                                                    {booking.service.title}
                                                </Link>
                                            </CardTitle>
                                            <CardDescription className="text-xs">
                                                On {new Date(booking.eventDate).toLocaleDateString()} with {booking.service.vendor.name}
                                            </CardDescription>
                                        </div>
                                        <Badge variant="outline" className={statusProps.color}>
                                            {statusProps.icon} {statusProps.text}
                                        </Badge>
                                    </CardHeader>
                                    {/* Optional: Add a footer for actions like "Leave a Review" or "Book Again" */}
                                </Card>
                             )
                        })}
                    </div>
                 </section>
            )}
          </div>
        )}
      </div>
    </Layout>
  );
};

export default BookingsPage;
