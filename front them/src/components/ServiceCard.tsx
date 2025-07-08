import { Link } from "react-router-dom";
import { Heart, Star, MapPin, Clock } from "lucide-react";
import { Service } from "@/types";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import { FleurDeLis, RoyalOrnament } from "@/components/RoyalMotifs";

interface ServiceCardProps {
  service: Service;
  className?: string;
}

export function ServiceCard({ service, className = "" }: ServiceCardProps) {
  const primaryImage = service.images.find(img => img.isPrimary) || service.images[0];
  
  return (
    <div className={`card-royal hover-lift group relative ${className}`}>
      {/* Royal Corner Ornament */}
      <div className="absolute top-2 left-2 opacity-20 group-hover:opacity-40 transition-opacity">
        <FleurDeLis className="text-primary" size={20} />
      </div>
      {/* Image */}
        <div className="relative overflow-hidden rounded-t-xl">
          <img
          src={primaryImage?.path || '/api/placeholder/400/250'}
          alt={primaryImage?.alt || service.title}
          className="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-105"
        />
        <div className="absolute top-4 right-4">
          <Button size="sm" variant="outline" className="bg-white/90 hover:bg-white">
            <Heart className="h-4 w-4" />
          </Button>
        </div>
        {service.featured && (
          <div className="absolute top-4 left-4 flex items-center gap-2">
            <RoyalOrnament className="text-primary" size={16} />
            <Badge className="bg-primary text-primary-foreground">
              Featured
            </Badge>
          </div>
        )}
      </div>

      {/* Content */}
      <div className="p-6 relative">
        {/* Royal divider at top */}
        <div className="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
          <div className="bg-white px-3">
            <FleurDeLis className="text-primary" size={16} />
          </div>
        </div>
        {/* Vendor & Category */}
        <div className="flex items-center justify-between mb-2">
          <Link 
            to={`/vendor/${service.vendor.id}`}
            className="text-sm font-medium text-muted-foreground hover:text-primary transition-colors"
          >
            {service.vendor.name}
          </Link>
          <Badge variant="secondary" className="text-xs">
            {service.category}
          </Badge>
        </div>

        {/* Title */}
        <Link to={`/service/${service.slug}`}>
          <h3 className="font-serif text-lg font-semibold text-foreground hover:text-primary transition-colors mb-2 line-clamp-2">
            {service.title}
          </h3>
        </Link>

        {/* Description */}
        <p className="text-sm text-muted-foreground mb-4 line-clamp-2">
          {service.shortDescription}
        </p>

        {/* Location & Rating */}
        <div className="flex items-center gap-4 mb-4 text-sm text-muted-foreground">
          <div className="flex items-center gap-1">
            <MapPin className="h-4 w-4" />
            <span>{service.location}</span>
          </div>
          <div className="flex items-center gap-1">
            <Star className="h-4 w-4 fill-amber-400 text-amber-400" />
            <span className="font-medium">{service.rating}</span>
            <span>({service.reviewCount})</span>
          </div>
        </div>

        {/* Features */}
        <div className="flex flex-wrap gap-1 mb-4">
          {service.features.slice(0, 2).map((feature, index) => (
            <Badge key={index} variant="outline" className="text-xs">
              {feature}
            </Badge>
          ))}
          {service.features.length > 2 && (
            <Badge variant="outline" className="text-xs">
              +{service.features.length - 2} more
            </Badge>
          )}
        </div>

        {/* Price & Action */}
        <div className="flex items-center justify-between">
          <div>
            <span className="text-lg font-bold text-primary">
              ${service.priceFrom.toLocaleString()}
              {service.priceTo && ` - $${service.priceTo.toLocaleString()}`}
            </span>
            <span className="text-sm text-muted-foreground ml-1">
              / {service.unit}
            </span>
          </div>
          <Button size="sm" className="btn-royal">
            View Details
          </Button>
        </div>
      </div>
    </div>
  );
}