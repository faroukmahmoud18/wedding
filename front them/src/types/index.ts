export interface Vendor {
  id: string;
  name: string;
  logo?: string;
  about: string;
  phone: string;
  email: string;
  address: string;
  rating: number;
  reviewCount: number;
  verified: boolean;
  featured: boolean;
}

export interface Service {
  id: string;
  vendorId: string;
  vendor: Vendor;
  category: ServiceCategory;
  title: string;
  slug: string;
  shortDescription: string;
  longDescription: string;
  priceFrom: number;
  priceTo?: number;
  unit: string;
  isActive: boolean;
  images: ServiceImage[];
  features: string[];
  location: string;
  rating: number;
  reviewCount: number;
  featured: boolean;
}

export interface ServiceImage {
  id: string;
  serviceId: string;
  path: string;
  alt: string;
  isPrimary: boolean;
}

export interface ServiceMeta {
  id: string;
  serviceId: string;
  metaKey: string;
  metaValue: string;
}

export interface Booking {
  id: string;
  serviceId: string;
  service: Service;
  userId: string;
  eventDate: string;
  quantity: number;
  total: number;
  status: BookingStatus;
  notes?: string;
  createdAt: string;
}

export interface Review {
  id: string;
  serviceId: string;
  userId: string;
  userName: string;
  userAvatar?: string;
  rating: number;
  comment: string;
  approved: boolean;
  createdAt: string;
}

export type ServiceCategory = 'photography' | 'venues' | 'dresses' | 'makeup';

export type BookingStatus = 'pending' | 'confirmed' | 'completed' | 'cancelled';

export interface SearchFilters {
  category?: ServiceCategory;
  priceMin?: number;
  priceMax?: number;
  rating?: number;
  location?: string;
  features?: string[];
  sortBy?: 'price' | 'rating' | 'popularity' | 'newest';
  sortOrder?: 'asc' | 'desc';
}