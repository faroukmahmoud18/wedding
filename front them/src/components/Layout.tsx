import { Link, useLocation } from "react-router-dom";
import { Crown, Search, Heart, User, Menu, X } from "lucide-react";
import { useState } from "react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { RoyalCrown, FleurDeLis, RoyalOrnament } from "@/components/RoyalMotifs";

const navigation = [
  { name: "Home", href: "/" },
  { name: "Photography", href: "/category/photography" },
  { name: "Venues", href: "/category/venues" },
  { name: "Dresses", href: "/category/dresses" },
  { name: "Makeup", href: "/category/makeup" },
];

interface LayoutProps {
  children: React.ReactNode;
}

export function Layout({ children }: LayoutProps) {
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
  const location = useLocation();

  return (
    <div className="min-h-screen bg-background relative">
      {/* Royal Background Pattern */}
      <div className="fixed inset-0 opacity-5 pointer-events-none">
        <div className="absolute top-20 left-10">
          <RoyalOrnament className="text-primary" size={60} />
        </div>
        <div className="absolute top-40 right-20">
          <FleurDeLis className="text-primary" size={40} />
        </div>
        <div className="absolute bottom-40 left-20">
          <RoyalCrown className="text-primary" size={50} />
        </div>
        <div className="absolute bottom-20 right-10">
          <RoyalOrnament className="text-primary" size={70} />
        </div>
      </div>
      
      {/* Header */}
      <header className="bg-warm-ivory/90 backdrop-blur-sm border-b border-border sticky top-0 z-50 relative">
        <div className="container mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex items-center justify-between h-16">
            {/* Logo */}
            <Link to="/" className="flex items-center space-x-3">
              <div className="relative">
                <RoyalCrown className="h-8 w-8 text-primary" />
                <div className="absolute -top-1 -right-1">
                  <FleurDeLis className="h-4 w-4 text-primary" />
                </div>
              </div>
              <span className="font-serif text-2xl font-bold text-royal-gold">
                Royal Vows
              </span>
            </Link>

            {/* Desktop Navigation */}
            <nav className="hidden md:flex items-center space-x-8">
              {navigation.map((item) => (
                <Link
                  key={item.name}
                  to={item.href}
                  className={`text-sm font-medium transition-colors hover:text-primary ${
                    location.pathname === item.href
                      ? "text-primary border-b-2 border-primary"
                      : "text-muted-foreground"
                  }`}
                >
                  {item.name}
                </Link>
              ))}
            </nav>

            {/* Search & Actions */}
            <div className="hidden md:flex items-center space-x-4">
              <div className="relative">
                <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-muted-foreground" />
                <Input
                  placeholder="Search services..."
                  className="pl-10 w-64 bg-background"
                />
              </div>
              <Button size="sm" variant="outline">
                <Heart className="h-4 w-4 mr-2" />
                Favorites
              </Button>
              <Button size="sm" className="btn-royal">
                <User className="h-4 w-4 mr-2" />
                Sign In
              </Button>
            </div>

            {/* Mobile menu button */}
            <button
              className="md:hidden p-2"
              onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
            >
              {mobileMenuOpen ? (
                <X className="h-6 w-6" />
              ) : (
                <Menu className="h-6 w-6" />
              )}
            </button>
          </div>

          {/* Mobile Navigation */}
          {mobileMenuOpen && (
            <div className="md:hidden py-4 border-t border-border">
              <div className="flex flex-col space-y-4">
                {navigation.map((item) => (
                  <Link
                    key={item.name}
                    to={item.href}
                    className="text-sm font-medium text-muted-foreground hover:text-primary"
                    onClick={() => setMobileMenuOpen(false)}
                  >
                    {item.name}
                  </Link>
                ))}
                <div className="pt-4 border-t border-border">
                  <Input placeholder="Search services..." className="mb-3" />
                  <div className="flex flex-col space-y-2">
                    <Button size="sm" variant="outline" className="w-full">
                      <Heart className="h-4 w-4 mr-2" />
                      Favorites
                    </Button>
                    <Button size="sm" className="btn-royal w-full">
                      <User className="h-4 w-4 mr-2" />
                      Sign In
                    </Button>
                  </div>
                </div>
              </div>
            </div>
          )}
        </div>
      </header>

      {/* Main Content */}
      <main>{children}</main>

      {/* Footer */}
      <footer className="bg-royal-deep-brown text-royal-ivory mt-20">
        <div className="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
          <div className="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div className="col-span-1 md:col-span-2">
              <div className="flex items-center space-x-2 mb-4">
                <Crown className="h-8 w-8 text-primary" />
                <span className="font-serif text-2xl font-bold text-royal-gold">
                  Royal Vows
                </span>
              </div>
              <p className="text-royal-ivory/80 mb-4">
                Discover the finest wedding services from premium vendors. 
                Create your perfect royal wedding experience.
              </p>
            </div>
            
            <div>
              <h3 className="font-serif text-lg font-semibold mb-4 text-royal-gold">Services</h3>
              <ul className="space-y-2">
                <li><Link to="/category/photography" className="text-royal-ivory/80 hover:text-royal-gold transition-colors">Photography</Link></li>
                <li><Link to="/category/venues" className="text-royal-ivory/80 hover:text-royal-gold transition-colors">Venues</Link></li>
                <li><Link to="/category/dresses" className="text-royal-ivory/80 hover:text-royal-gold transition-colors">Dresses</Link></li>
                <li><Link to="/category/makeup" className="text-royal-ivory/80 hover:text-royal-gold transition-colors">Makeup</Link></li>
              </ul>
            </div>
            
            <div>
              <h3 className="font-serif text-lg font-semibold mb-4 text-royal-gold">Support</h3>
              <ul className="space-y-2">
                <li><Link to="/help" className="text-royal-ivory/80 hover:text-royal-gold transition-colors">Help Center</Link></li>
                <li><Link to="/contact" className="text-royal-ivory/80 hover:text-royal-gold transition-colors">Contact Us</Link></li>
                <li><Link to="/vendor" className="text-royal-ivory/80 hover:text-royal-gold transition-colors">Become a Vendor</Link></li>
              </ul>
            </div>
          </div>
          
          <div className="border-t border-royal-ivory/20 mt-8 pt-8 text-center">
            <p className="text-royal-ivory/60">
              © 2024 Royal Vows. All rights reserved. Creating magical moments since forever.
            </p>
          </div>
        </div>
      </footer>
    </div>
  );
}