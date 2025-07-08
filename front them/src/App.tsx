import { Toaster } from "@/components/ui/toaster";
import { Toaster as Sonner } from "@/components/ui/sonner";
import { TooltipProvider } from "@/components/ui/tooltip";
import { QueryClient, QueryClientProvider } from "@tanstack/react-query";
import { BrowserRouter, Routes, Route } from "react-router-dom";
import { QueryClient, QueryClientProvider } from "@tanstack/react-query";
import { TooltipProvider } from "@/components/ui/tooltip";
import { Toaster } from "@/components/ui/toaster";
import { Toaster as Sonner } from "@/components/ui/sonner";

// Page Imports
import Index from "./pages/Index";
import NotFound from "./pages/NotFound";
import ServiceCategoryPage from "./pages/ServiceCategoryPage";
import ServiceDetailPage from "./pages/ServiceDetailPage";
import VendorProfilePage from "./pages/VendorProfilePage";
import DashboardPage from "./pages/DashboardPage"; // This will be the main entry for dashboard
import BookingsPage from "./pages/BookingsPage";
import AboutPage from "./pages/AboutPage";
import ContactPage from "./pages/ContactPage";
import LoginPage from "./pages/LoginPage";
import RegisterPage from "./pages/RegisterPage";

// Protected Route Component
import ProtectedRoute from "./components/ProtectedRoute";

// Admin Dashboard Pages (example, will be created later)
// import ManageVendorsPage from "./pages/admin/ManageVendorsPage";
// import ManageServicesPage from "./pages/admin/ManageServicesPage";

// Vendor Dashboard Pages (example, will be created later)
// import MyServicesPage from "./pages/vendor/MyServicesPage";
// import MyVendorBookingsPage from "./pages/vendor/MyVendorBookingsPage";


const queryClient = new QueryClient();

const App = () => (
  <QueryClientProvider client={queryClient}>
    <TooltipProvider>
      <Toaster />
      <Sonner />
      <BrowserRouter>
        <Routes>
          {/* Public Routes */}
          <Route path="/" element={<Index />} />
          <Route path="/login" element={<LoginPage />} />
          <Route path="/register" element={<RegisterPage />} />
          <Route path="/services/:categorySlug" element={<ServiceCategoryPage />} />
          <Route path="/services/:categorySlug/:serviceId" element={<ServiceDetailPage />} />
          <Route path="/vendors/:vendorId" element={<VendorProfilePage />} />
          <Route path="/about" element={<AboutPage />} />
          <Route path="/contact" element={<ContactPage />} />

          {/* Protected Routes */}
          {/* Example: Dashboard accessible by any authenticated user, specific views handled inside DashboardPage */}
          <Route path="/dashboard" element={<ProtectedRoute />}>
            <Route index element={<DashboardPage />} />
            {/*
              Nested routes for admin specific sections:
              Will be like:
              <Route path="admin/vendors" element={<ProtectedRoute allowedRoles={['admin']}><ManageVendorsPage /></ProtectedRoute>} />
              <Route path="admin/services" element={<ProtectedRoute allowedRoles={['admin']}><ManageServicesPage /></ProtectedRoute>} />
            */}
            {/*
              Nested routes for vendor specific sections:
              Will be like:
              <Route path="vendor/my-services" element={<ProtectedRoute allowedRoles={['vendor']}><MyServicesPage /></ProtectedRoute>} />
              <Route path="vendor/bookings" element={<ProtectedRoute allowedRoles={['vendor']}><MyVendorBookingsPage /></ProtectedRoute>} />
            */}
          </Route>

          <Route path="/bookings" element={
            <ProtectedRoute allowedRoles={['user', 'vendor', 'admin']}>
              <BookingsPage />
            </ProtectedRoute>
          } />

          {/* ADD ALL CUSTOM ROUTES ABOVE THE CATCH-ALL "*" ROUTE */}
          <Route path="*" element={<NotFound />} />
        </Routes>
      </BrowserRouter>
    </TooltipProvider>
  </QueryClientProvider>
);

export default App;
