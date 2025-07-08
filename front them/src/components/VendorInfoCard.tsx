import { Vendor } from "@/types";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
import { RoyalCrown, FleurDeLis } from "@/components/RoyalMotifs";
import { Mail, Phone, MapPin, Star } from "lucide-react";

interface VendorInfoCardProps {
  vendor: Vendor;
}

export function VendorInfoCard({ vendor }: VendorInfoCardProps) {
  return (
    <Card className="card-royal w-full shadow-elegant">
      <CardHeader className="relative text-center pb-8">
        <div className="absolute top-4 right-4">
          <FleurDeLis className="text-primary opacity-30" size={32} />
        </div>
        <div className="absolute top-4 left-4">
          <FleurDeLis className="text-primary opacity-30" size={32} />
        </div>
        <div className="w-24 h-24 bg-muted rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-primary/50 shadow-md">
          {/* Placeholder for actual vendor logo - using RoyalCrown for now */}
          <RoyalCrown className="text-primary" size={48} />
        </div>
        <CardTitle className="font-serif text-3xl text-royal-deep-brown">{vendor.name}</CardTitle>
        {vendor.verified && (
          <Badge className="mx-auto mt-2 bg-primary text-primary-foreground">
            <Star className="h-3 w-3 mr-1 fill-current" /> Verified Vendor
          </Badge>
        )}
         <div className="mt-2 flex items-center justify-center gap-1 text-sm text-muted-foreground">
            <Star className="h-4 w-4 fill-amber-400 text-amber-400" />
            <span className="font-medium">{vendor.rating}</span>
            <span>({vendor.reviewCount} reviews)</span>
        </div>
      </CardHeader>
      <CardContent className="space-y-4 pt-6 border-t border-border">
        <div>
          <h3 className="font-serif text-lg font-semibold text-royal-deep-brown mb-2">About {vendor.name}</h3>
          <p className="text-muted-foreground text-sm leading-relaxed">{vendor.about}</p>
        </div>

        <div className="space-y-2 pt-4 border-t border-border">
            <h4 className="font-serif text-md font-semibold text-royal-deep-brown">Contact Information</h4>
            {vendor.address && (
                <div className="flex items-center text-sm text-muted-foreground">
                    <MapPin className="h-4 w-4 mr-3 text-primary flex-shrink-0" />
                    <span>{vendor.address}</span>
                </div>
            )}
            {vendor.phone && (
                <div className="flex items-center text-sm text-muted-foreground">
                    <Phone className="h-4 w-4 mr-3 text-primary flex-shrink-0" />
                    <a href={`tel:${vendor.phone}`} className="hover:text-primary">{vendor.phone}</a>
                </div>
            )}
            {vendor.email && (
                <div className="flex items-center text-sm text-muted-foreground">
                    <Mail className="h-4 w-4 mr-3 text-primary flex-shrink-0" />
                     <a href={`mailto:${vendor.email}`} className="hover:text-primary">{vendor.email}</a>
                </div>
            )}
        </div>
      </CardContent>
    </Card>
  );
}
