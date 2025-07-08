import { Layout } from "@/components/Layout";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";
import { Card, CardHeader, CardTitle, CardDescription, CardContent, CardFooter } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { RoyalCrown, FleurDeLis, RoyalOrnament } from "@/components/RoyalMotifs";
import { sampleServices, sampleVendors } from "@/data/sampleData"; // Using sample data for now
import { ServiceCard } from "@/components/ServiceCard";
import { Badge } from "@/components/ui/badge";
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Edit, Trash2, Eye, CheckCircle, XCircle, ToggleLeft, ToggleRight } from "lucide-react";

// Assume a user role for now, this would come from auth state
type UserRole = "vendor" | "admin" | "user";
const currentUserRole: UserRole = "admin"; // Change to 'vendor' or 'user' to test different views

const DashboardPage = () => {
  // Filter data based on role (simplified for now)
  const vendorServices = currentUserRole === "vendor"
    ? sampleServices.filter(s => s.vendorId === sampleVendors[0]?.id) // Assuming first vendor for demo
    : [];

  // Placeholder for booking requests
  const bookingRequests = [
    { id: "b1", serviceName: sampleServices[0]?.title, userName: "Princess Aurora", date: "2024-12-15", status: "Pending" },
    { id: "b2", serviceName: sampleServices[1]?.title, userName: "Prince Charming", date: "2025-01-20", status: "Confirmed" },
  ];

  const AdminVendorTab = () => (
    <Card className="card-royal">
      <CardHeader>
        <CardTitle className="font-serif text-xl text-royal-deep-brown">Manage Vendors</CardTitle>
        <CardDescription>View, edit, or toggle vendor status.</CardDescription>
      </CardHeader>
      <CardContent>
        <Table>
          <TableHeader>
            <TableRow>
              <TableHead>Name</TableHead>
              <TableHead>Email</TableHead>
              <TableHead className="text-center">Status</TableHead>
              <TableHead className="text-right">Actions</TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            {sampleVendors.map(vendor => (
              <TableRow key={vendor.id}>
                <TableCell className="font-medium">{vendor.name} {vendor.featured && <Badge variant="secondary" className="ml-1">Featured</Badge>}</TableCell>
                <TableCell>{vendor.email}</TableCell>
                <TableCell className="text-center">
                  <Badge variant={vendor.verified ? "default" : "outline"} className={vendor.verified ? "bg-green-600 hover:bg-green-700 text-white" : ""}>
                    {vendor.verified ? <CheckCircle className="h-4 w-4 mr-1 inline"/> : <XCircle className="h-4 w-4 mr-1 inline"/>}
                    {vendor.verified ? "Verified" : "Pending"}
                  </Badge>
                </TableCell>
                <TableCell className="text-right space-x-1">
                  <Button variant="outline" size="icon-sm"><Eye className="h-4 w-4" /></Button>
                  <Button variant="outline" size="icon-sm"><Edit className="h-4 w-4" /></Button>
                  <Button variant={vendor.verified ? "destructive" : "default"} size="icon-sm" className={vendor.verified ? "" : "bg-green-600 hover:bg-green-700"}>
                    {vendor.verified ? <ToggleRight className="h-4 w-4" /> : <ToggleLeft className="h-4 w-4" />}
                  </Button>
                </TableCell>
              </TableRow>
            ))}
          </TableBody>
        </Table>
      </CardContent>
    </Card>
  );

  const AdminServiceTab = () => (
     <Card className="card-royal">
      <CardHeader>
        <CardTitle className="font-serif text-xl text-royal-deep-brown">Manage Services</CardTitle>
        <CardDescription>View, edit, or toggle service status.</CardDescription>
      </CardHeader>
      <CardContent>
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            {sampleServices.map(service => (
                <Card key={service.id} className="relative group">
                    <img src={service.images.find(img => img.isPrimary)?.path || '/api/placeholder/400/200'} alt={service.title} className="w-full h-32 object-cover rounded-t-lg"/>
                    <CardHeader className="pb-2">
                        <CardTitle className="font-serif text-lg line-clamp-1">{service.title}</CardTitle>
                        <CardDescription className="text-xs">By {service.vendor.name}</CardDescription>
                    </CardHeader>
                    <CardContent className="text-xs">
                         <Badge variant={service.isActive ? "default" : "outline"} className={service.isActive ? "bg-green-600 hover:bg-green-700 text-white" : ""}>
                            {service.isActive ? "Active" : "Inactive"}
                        </Badge>
                        {service.featured && <Badge className="ml-1 bg-primary text-primary-foreground">Featured</Badge>}
                    </CardContent>
                    <CardFooter className="flex justify-end space-x-1 p-2">
                        <Button variant="outline" size="icon-sm"><Eye className="h-4 w-4" /></Button>
                        <Button variant="outline" size="icon-sm"><Edit className="h-4 w-4" /></Button>
                        <Button variant={service.isActive ? "destructive" : "default"} size="icon-sm"  className={service.isActive ? "" : "bg-green-600 hover:bg-green-700"}>
                             {service.isActive ? <ToggleRight className="h-4 w-4" /> : <ToggleLeft className="h-4 w-4" />}
                        </Button>
                    </CardFooter>
                </Card>
            ))}
        </div>
      </CardContent>
    </Card>
  );

  const VendorServicesTab = () => (
    <Card className="card-royal">
      <CardHeader className="flex flex-row items-center justify-between">
        <div>
            <CardTitle className="font-serif text-xl text-royal-deep-brown">My Services</CardTitle>
            <CardDescription>Manage your listed services.</CardDescription>
        </div>
        <Button className="btn-royal">Add New Service</Button>
      </CardHeader>
      <CardContent>
        {vendorServices.length > 0 ? (
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            {vendorServices.map(service => <ServiceCard key={service.id} service={service} />)}
          </div>
        ) : <p className="text-muted-foreground">You have no services listed yet.</p>}
      </CardContent>
    </Card>
  );

  const VendorBookingsTab = () => (
    <Card className="card-royal">
      <CardHeader>
        <CardTitle className="font-serif text-xl text-royal-deep-brown">Booking Requests</CardTitle>
        <CardDescription>View and manage incoming booking requests.</CardDescription>
      </CardHeader>
      <CardContent>
        <Table>
          <TableHeader>
            <TableRow>
              <TableHead>Service</TableHead>
              <TableHead>User</TableHead>
              <TableHead>Date</TableHead>
              <TableHead>Status</TableHead>
              <TableHead className="text-right">Actions</TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            {bookingRequests.map(req => (
              <TableRow key={req.id}>
                <TableCell className="font-medium">{req.serviceName}</TableCell>
                <TableCell>{req.userName}</TableCell>
                <TableCell>{req.date}</TableCell>
                <TableCell>
                  <Badge variant={req.status === "Confirmed" ? "default" : req.status === "Pending" ? "secondary" : "destructive"}
                         className={req.status === "Confirmed" ? "bg-green-600 hover:bg-green-700 text-white" : ""}>
                    {req.status}
                  </Badge>
                </TableCell>
                <TableCell className="text-right space-x-1">
                  <Button variant="outline" size="sm">View</Button>
                  {req.status === "Pending" && <Button size="sm" className="bg-green-600 hover:bg-green-700 text-white">Confirm</Button>}
                </TableCell>
              </TableRow>
            ))}
          </TableBody>
        </Table>
      </CardContent>
    </Card>
  );

  const renderTabs = () => {
    switch (currentUserRole) {
      case "admin":
        return (
          <Tabs defaultValue="vendors" className="w-full">
            <TabsList className="grid w-full grid-cols-2 bg-card mb-6">
              <TabsTrigger value="vendors">Manage Vendors</TabsTrigger>
              <TabsTrigger value="services">Manage Services</TabsTrigger>
            </TabsList>
            <TabsContent value="vendors"><AdminVendorTab /></TabsContent>
            <TabsContent value="services"><AdminServiceTab /></TabsContent>
          </Tabs>
        );
      case "vendor":
        return (
          <Tabs defaultValue="my-services" className="w-full">
            <TabsList className="grid w-full grid-cols-2 bg-card mb-6">
              <TabsTrigger value="my-services">My Services</TabsTrigger>
              <TabsTrigger value="booking-requests">Booking Requests</TabsTrigger>
            </TabsList>
            <TabsContent value="my-services"><VendorServicesTab /></TabsContent>
            <TabsContent value="booking-requests"><VendorBookingsTab /></TabsContent>
          </Tabs>
        );
      default: // Regular user dashboard (e.g., link to bookings, profile settings)
        return (
            <Card className="card-royal">
                <CardHeader>
                    <CardTitle className="font-serif text-xl text-royal-deep-brown">Welcome to your Dashboard</CardTitle>
                    <CardDescription>Manage your wedding planning activities.</CardDescription>
                </CardHeader>
                <CardContent className="space-y-4">
                    <Button asChild variant="outline" className="w-full justify-start">
                        <Link to="/bookings">
                            <CalendarDays className="mr-2 h-4 w-4" /> My Bookings
                        </Link>
                    </Button>
                     <Button variant="outline" className="w-full justify-start">
                        <Heart className="mr-2 h-4 w-4" /> My Favorites
                    </Button>
                    <Button variant="outline" className="w-full justify-start">
                        <User className="mr-2 h-4 w-4" /> My Profile
                    </Button>
                </CardContent>
            </Card>
        );
    }
  };

  return (
    <Layout>
      <div className="container mx-auto px-4 py-8">
        <div className="flex items-center justify-between mb-8">
            <div className="flex items-center">
                {currentUserRole === 'admin' && <RoyalCrown className="text-primary mr-3" size={36} />}
                {currentUserRole === 'vendor' && <FleurDeLis className="text-primary mr-3" size={32} />}
                {currentUserRole === 'user' && <RoyalOrnament className="text-primary mr-3" size={32} />}
                <h1 className="font-serif text-3xl sm:text-4xl font-bold text-royal-deep-brown">
                {currentUserRole === 'admin' && "Admin Dashboard"}
                {currentUserRole === 'vendor' && "Vendor Dashboard"}
                {currentUserRole === 'user' && "My Dashboard"}
                </h1>
            </div>
            {/* Add any global dashboard actions here, e.g., settings button */}
        </div>
        {renderTabs()}
      </div>
    </Layout>
  );
};

export default DashboardPage;
