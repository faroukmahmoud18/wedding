import { Vendor, Service, ServiceCategory } from "@/types";

export const sampleVendors: Vendor[] = [
  {
    id: '1',
    name: 'Elegant Moments Photography',
    about: 'Award-winning wedding photographers capturing timeless moments with artistic vision.',
    phone: '+1 (555) 123-4567',
    email: 'info@elegantmoments.com',
    address: 'Beverly Hills, CA',
    rating: 4.9,
    reviewCount: 127,
    verified: true,
    featured: true,
  },
  {
    id: '2', 
    name: 'Golden Manor Venues',
    about: 'Luxurious wedding venues with breathtaking gardens and ballrooms.',
    phone: '+1 (555) 234-5678',
    email: 'events@goldenmanor.com', 
    address: 'Napa Valley, CA',
    rating: 4.8,
    reviewCount: 89,
    verified: true,
    featured: true,
  },
  {
    id: '3',
    name: 'Couture Bridal Boutique',
    about: 'Designer wedding dresses and custom alterations by master seamstresses.',
    phone: '+1 (555) 345-6789',
    email: 'hello@coutureboutique.com',
    address: 'Manhattan, NY',
    rating: 4.9,
    reviewCount: 203,
    verified: true,
    featured: true,
  },
  {
    id: '4',
    name: 'Royal Beauty Studio',
    about: 'Professional bridal makeup and hairstyling for your special day.',
    phone: '+1 (555) 456-7890',
    email: 'bookings@royalbeauty.com',
    address: 'Los Angeles, CA',
    rating: 4.7,
    reviewCount: 156,
    verified: true,
    featured: false,
  },
];

export const sampleServices: Service[] = [
  {
    id: '1',
    vendorId: '1',
    vendor: sampleVendors[0],
    category: 'photography',
    title: 'Premium Wedding Photography Package',
    slug: 'premium-wedding-photography',
    shortDescription: 'Full-day coverage with 2 photographers, editing, and digital gallery.',
    longDescription: 'Our premium package includes 8-10 hours of wedding day coverage with two professional photographers, comprehensive editing of 500+ images, an online gallery for sharing, and a beautifully designed wedding album. We specialize in capturing both candid moments and stunning portraits with a timeless, elegant style.',
    priceFrom: 3500,
    priceTo: 5500,
    unit: 'package',
    isActive: true,
    images: [
      {
        id: '1',
        serviceId: '1',
        path: '/api/placeholder/800/600',
        alt: 'Wedding ceremony photography',
        isPrimary: true,
      },
      {
        id: '2',
        serviceId: '1', 
        path: '/api/placeholder/800/600',
        alt: 'Bridal portraits',
        isPrimary: false,
      },
    ],
    features: ['2 Professional Photographers', '8-10 Hours Coverage', '500+ Edited Photos', 'Online Gallery', 'Wedding Album', 'Engagement Session'],
    location: 'Beverly Hills, CA',
    rating: 4.9,
    reviewCount: 87,
    featured: true,
  },
  {
    id: '2',
    vendorId: '2',
    vendor: sampleVendors[1],
    category: 'venues',
    title: 'Enchanted Garden Wedding Venue',
    slug: 'enchanted-garden-venue',
    shortDescription: 'Romantic outdoor ceremony space with elegant indoor reception hall.',
    longDescription: 'Say "I do" in our magical garden setting with century-old oak trees, flowing fountains, and blooming rose gardens. The venue includes a stunning outdoor ceremony space, elegant ballroom for up to 200 guests, bridal suite, groom\'s quarters, full catering kitchen, and dedicated event coordination.',
    priceFrom: 8000,
    priceTo: 15000,
    unit: 'event',
    isActive: true,
    images: [
      {
        id: '3',
        serviceId: '2',
        path: '/api/placeholder/800/600',
        alt: 'Garden ceremony setup',
        isPrimary: true,
      },
      {
        id: '4',
        serviceId: '2',
        path: '/api/placeholder/800/600', 
        alt: 'Reception ballroom',
        isPrimary: false,
      },
    ],
    features: ['Outdoor Ceremony Space', 'Indoor Reception Hall', 'Capacity 200 Guests', 'Bridal Suite', 'Full Catering Kitchen', 'Event Coordination', 'Parking for 100 Cars'],
    location: 'Napa Valley, CA',
    rating: 4.8,
    reviewCount: 64,
    featured: true,
  },
  {
    id: '3',
    vendorId: '3',
    vendor: sampleVendors[2],
    category: 'dresses',
    title: 'Designer Wedding Dress Collection',
    slug: 'designer-wedding-dress',
    shortDescription: 'Exclusive designer gowns with personalized fitting and alterations.',
    longDescription: 'Choose from our curated collection of designer wedding dresses from renowned fashion houses. Each dress comes with personalized fitting sessions, expert alterations, and styling consultation. We offer both purchase and rental options to fit every budget.',
    priceFrom: 1200,
    priceTo: 8000,
    unit: 'dress',
    isActive: true,
    images: [
      {
        id: '5',
        serviceId: '3',
        path: '/api/placeholder/800/600',
        alt: 'Designer wedding dress showcase',
        isPrimary: true,
      },
      {
        id: '6',
        serviceId: '3',
        path: '/api/placeholder/800/600',
        alt: 'Bridal fitting session',
        isPrimary: false,
      },
    ],
    features: ['Designer Collections', 'Personal Fitting', 'Expert Alterations', 'Styling Consultation', 'Purchase & Rental Options', 'Veil & Accessories'],
    location: 'Manhattan, NY',
    rating: 4.9,
    reviewCount: 142,
    featured: true,
  },
  {
    id: '4',
    vendorId: '4',
    vendor: sampleVendors[3],
    category: 'makeup',
    title: 'Bridal Beauty Complete Package',
    slug: 'bridal-beauty-package',
    shortDescription: 'Professional makeup and hairstyling for the bride and bridal party.',
    longDescription: 'Transform into the most beautiful version of yourself with our complete bridal beauty package. Includes consultation, trial session, wedding day makeup and hair, touch-up kit, and services for up to 4 bridal party members. We use only premium products and techniques.',
    priceFrom: 800,
    priceTo: 2000,
    unit: 'package',
    isActive: true,
    images: [
      {
        id: '7',
        serviceId: '4',
        path: '/api/placeholder/800/600',
        alt: 'Bridal makeup application',
        isPrimary: true,
      },
      {
        id: '8',
        serviceId: '4',
        path: '/api/placeholder/800/600',
        alt: 'Bridal hairstyling',
        isPrimary: false,
      },
    ],
    features: ['Bridal Consultation', 'Trial Session', 'Wedding Day Makeup', 'Hairstyling', 'Touch-up Kit', 'Bridal Party Services (4 people)', 'Premium Products'],
    location: 'Los Angeles, CA',
    rating: 4.7,
    reviewCount: 98,
    featured: false,
  },
];

export const categoryConfig = {
  photography: {
    title: 'Wedding Photography',
    description: 'Capture your special moments with professional wedding photographers',
    icon: '📸',
    gradient: 'from-purple-400 to-pink-400',
  },
  venues: {
    title: 'Wedding Venues',
    description: 'Find the perfect location for your dream wedding ceremony and reception',
    icon: '🏰',
    gradient: 'from-blue-400 to-cyan-400',
  },
  dresses: {
    title: 'Wedding Dresses',
    description: 'Discover stunning wedding dresses from top designers and boutiques',
    icon: '👗',
    gradient: 'from-pink-400 to-rose-400',
  },
  makeup: {
    title: 'Bridal Makeup',
    description: 'Professional makeup and hairstyling services for your wedding day',
    icon: '💄',
    gradient: 'from-amber-400 to-orange-400',
  },
};