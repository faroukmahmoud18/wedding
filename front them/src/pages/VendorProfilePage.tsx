import { Layout } from "@/components/Layout";
import { useParams, Link } from "react-router-dom";
import { sampleServices, sampleVendors } from "@/data/sampleData";
import { Vendor, Service } from "@/types";
import { ServiceCard } from "@/components/ServiceCard";
import { VendorInfoCard } from "@/components/VendorInfoCard";
import { Button } from "@/components/ui/button";
import { RoyalOrnament, RoyalBorder } from "@/components/RoyalMotifs";
import { useQuery } from "@tanstack/react-query"; // For potential future API calls

// Simulate fetching data
const fetchVendorDetails = async (vendorId: string | undefined): Promise<Vendor | undefined> => {
  if (!vendorId) return undefined;
  return sampleVendors.find(vendor => vendor.id === vendorId);
};

const fetchServicesByVendor = async (vendorId: string | undefined): Promise<Service[]> => {
  if (!vendorId) return [];
  return sampleServices.filter(service => service.vendorId === vendorId);
};

const VendorProfilePage = () => {
  const { vendorId } = useParams<{ vendorId: string }>();

  // Replace with React Query for actual data fetching
  // const { data: vendor, isLoading: vendorLoading, error: vendorError } = useQuery<Vendor | undefined, Error>(
  //   ['vendor', vendorId],
  //   () => fetchVendorDetails(vendorId),
  //   { enabled: !!vendorId }
  // );
  // const { data: services, isLoading: servicesLoading, error: servicesError } = useQuery<Service[], Error>(
  //   ['servicesByVendor', vendorId],
  //   () => fetchServicesByVendor(vendorId),
  //   { enabled: !!vendorId }
  // );
  const vendor = sampleVendors.find(v => v.id === vendorId);
  const services = sampleServices.filter(s => s.vendorId === vendorId);

  if (!vendor) {
    return (
      <Layout>
        <div className="container mx-auto px-4 py-16 text-center">
          <RoyalOrnament className="text-primary opacity-50 mx-auto" size={60} />
          <h1 className="font-serif text-3xl font-bold text-royal-deep-brown mt-4">Vendor Not Found</h1>
          <p className="text-muted-foreground mt-4">The vendor you are looking for does not exist.</p>
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
        {/* Vendor Information Section */}
        <div className="mb-12">
          <VendorInfoCard vendor={vendor} />
        </div>

        {/* Services by this Vendor Section */}
        <div className="text-center mb-10">
            <h2 className="font-serif text-3xl sm:text-4xl font-bold text-royal-deep-brown mb-4">
                Services by {vendor.name}
            </h2>
            <div className="flex justify-center">
                <RoyalBorder className="text-primary" width={200} height={1} />
            </div>
        </div>

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
              {vendor.name} has not listed any services yet.
            </p>
          </div>
        )}

        {/* Optional: Contact CTA or Review Section can be added here */}
        {/*
        <div className="mt-16 text-center">
            <h3 className="font-serif text-2xl font-semibold text-royal-deep-brown mb-6">Interested in {vendor.name}'s services?</h3>
            <Button size="lg" className="btn-royal">Contact Vendor</Button>
        </div>
        */}
      </div>
    </Layout>
  );
};

export default VendorProfilePage;
