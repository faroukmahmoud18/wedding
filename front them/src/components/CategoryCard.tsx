import { Link } from "react-router-dom";
import { ArrowRight } from "lucide-react";
import { ServiceCategory } from "@/types";
import { categoryConfig } from "@/data/sampleData";
import { Button } from "@/components/ui/button";

interface CategoryCardProps {
  category: ServiceCategory;
  serviceCount: number;
  className?: string;
}

export function CategoryCard({ category, serviceCount, className = "" }: CategoryCardProps) {
  const config = categoryConfig[category];
  
  return (
    <Link to={`/category/${category}`}>
      <div className={`card-royal hover-lift group cursor-pointer ${className}`}>
        <div className={`h-32 bg-gradient-to-br ${config.gradient} rounded-t-xl flex items-center justify-center`}>
          <span className="text-4xl opacity-80">{config.icon}</span>
        </div>
        
        <div className="p-6">
          <h3 className="font-serif text-xl font-semibold mb-2 group-hover:text-primary transition-colors">
            {config.title}
          </h3>
          <p className="text-muted-foreground text-sm mb-4">
            {config.description}
          </p>
          <div className="flex items-center justify-between">
            <span className="text-sm text-muted-foreground">
              {serviceCount} services available
            </span>
            <ArrowRight className="h-4 w-4 text-primary opacity-0 group-hover:opacity-100 transition-opacity" />
          </div>
        </div>
      </div>
    </Link>
  );
}