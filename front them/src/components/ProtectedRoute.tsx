import { Navigate, Outlet, useLocation } from 'react-router-dom';
import { useAuth } from '@/hooks/useAuth';
import { ReactNode } from 'react';
import { RoyalOrnament } from './RoyalMotifs'; // For loading state

interface ProtectedRouteProps {
  allowedRoles?: Array<'user' | 'vendor' | 'admin'>; // Specify which roles can access
  children?: ReactNode; // Allow children for specific route components if needed
}

const ProtectedRoute = ({ allowedRoles, children }: ProtectedRouteProps) => {
  const { isAuthenticated, user, isLoading } = useAuth();
  const location = useLocation();

  if (isLoading) {
    // Optional: Show a loading spinner or a themed loading page
    return (
      <div className="min-h-screen flex flex-col items-center justify-center bg-background text-foreground">
        <RoyalOrnament className="text-primary animate-spin" size={60} />
        <p className="mt-4 font-serif text-xl text-royal-deep-brown">Loading Your Majesty's Page...</p>
      </div>
    );
  }

  if (!isAuthenticated) {
    // Redirect them to the /login page, but save the current location they were
    // trying to go to when they were redirected. This allows us to send them
    // along to that page after they login, which is a nicer user experience
    // than dropping them off on the home page.
    return <Navigate to="/login" state={{ from: location }} replace />;
  }

  // If allowedRoles are specified, check if the user's role is permitted
  if (allowedRoles && user && !allowedRoles.includes(user.role)) {
    // User is authenticated but does not have the required role
    // Redirect to an unauthorized page or dashboard, or show a message
    // For now, let's redirect to dashboard (which might then show an unauthorized message or different view)
    // A dedicated "/unauthorized" page would be better in a real app.
    return <Navigate to="/dashboard" state={{ from: location }} replace />;
    // Or: return <Navigate to="/unauthorized" replace />;
  }

  return children ? <>{children}</> : <Outlet />; // Render children if provided, otherwise Outlet for nested routes
};

export default ProtectedRoute;
