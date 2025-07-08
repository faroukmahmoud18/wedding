import { createContext, useContext, useState, useEffect, ReactNode, useCallback } from 'react';
// import { authService } from '@/services/authService'; // Will be uncommented later
// import { User } from '@/types'; // Assuming a User type exists or will be created

// Placeholder types - replace with actual types from @/types
interface User {
  id: string;
  name: string;
  email: string;
  role: 'user' | 'vendor' | 'admin'; // Example roles
  // Add other user properties as needed by your Laravel backend
  // e.g., email_verified_at, created_at, etc.
}

// Define specific types for login credentials and registration data
export interface LoginCredentials {
  email: string;
  password: string;
}

export interface RegisterData {
  name: string;
  email: string;
  password: string;
  role: 'user' | 'vendor'; // Assuming admin registration is separate
  // Add other fields as needed for your registration form e.g. confirmPassword (though that's usually client-side only)
}


interface AuthContextType {
  user: User | null;
  token: string | null;
  isAuthenticated: boolean;
  isLoading: boolean;
  login: (credentials: LoginCredentials) => Promise<void>;
  register: (userData: RegisterData) => Promise<void>;
  logout: () => void;
  // Add other auth-related functions if needed, e.g., verifyEmail, forgotPassword
}

const AuthContext = createContext<AuthContextType | undefined>(undefined);

export const AuthProvider = ({ children }: { children: ReactNode }) => {
  const [user, setUser] = useState<User | null>(null);
  const [token, setToken] = useState<string | null>(localStorage.getItem('authToken'));
  const [isLoading, setIsLoading] = useState(true); // Initially true to check token validity

  const fetchUserProfile = useCallback(async (currentToken: string) => {
    setIsLoading(true);
    try {
      // In a real app, you'd fetch the user profile from an API endpoint
      // const profile = await authService.getProfile(currentToken); // Example
      // For now, mock user based on token presence, or decode token if it's a JWT
      if (currentToken) {
        // This is a placeholder. Real implementation would verify token with backend.
        // If token is JWT, you might decode it here to get basic user info (but still verify with backend)
        const mockUser: User = {
            id: 'mockUserId',
            name: 'Mock User',
            email: 'user@example.com',
            role: 'user' // Default role, or determine from token/API
        };
        setUser(mockUser);
      } else {
        setUser(null);
      }
    } catch (error) {
      console.error("Failed to fetch user profile:", error);
      setUser(null);
      localStorage.removeItem('authToken');
      setToken(null);
    } finally {
      setIsLoading(false);
    }
  }, []);

  useEffect(() => {
    if (token) {
      // TODO: Add token validation logic here if necessary (e.g., check expiry if JWT)
      // For now, just assume token is valid and fetch profile
      fetchUserProfile(token);
    } else {
      setIsLoading(false); // No token, so not loading user profile
    }
  }, [token, fetchUserProfile]);

  const login = async (credentials: LoginCredentials) => {
    setIsLoading(true);
    try {
      // const { token: newToken, user: loggedInUser } = await authService.login(credentials); // Uncomment when authService is ready
      // Mock implementation for now:
      console.log('Attempting login with:', credentials); // Log credentials
      const newToken = 'mockAuthToken123';
      // For mock, derive role from email or use a default. In real app, backend provides this.
      const role = credentials.email.includes('admin') ? 'admin' : credentials.email.includes('vendor') ? 'vendor' : 'user';
      const loggedInUser: User = {
        id: 'mockLoginUser-' + Math.random().toString(36).substring(7),
        name: credentials.email.split('@')[0], // Simple name from email
        email: credentials.email,
        role: role
      };

      localStorage.setItem('authToken', newToken);
      setToken(newToken);
      setUser(loggedInUser);
    } catch (error) {
      console.error("Login failed:", error);
      throw error; // Re-throw to be caught by the form
    } finally {
      setIsLoading(false);
    }
  };

  const register = async (userData: RegisterData) => {
    setIsLoading(true);
    try {
      // const { token: newToken, user: registeredUser } = await authService.register(userData); // Uncomment when authService is ready
      // Mock implementation for now:
      console.log('Attempting registration with:', userData); // Log user data
      const newToken = 'mockRegisteredToken456';
      const registeredUser: User = {
        id: 'mockRegisteredUser-' + Math.random().toString(36).substring(7),
        name: userData.name,
        email: userData.email,
        role: userData.role
      };

      localStorage.setItem('authToken', newToken);
      setToken(newToken);
      setUser(registeredUser);
      // Typically, registration might not log the user in immediately, or might require email verification. Adjust as needed.
    } catch (error) {
      console.error("Registration failed:", error);
      throw error; // Re-throw
    } finally {
      setIsLoading(false);
    }
  };

  const logout = () => {
    // await authService.logout(); // Optional: Call backend logout endpoint if exists (e.g., to invalidate server-side session/token)
    setUser(null);
    setToken(null);
    localStorage.removeItem('authToken');
    // Optionally redirect to login page or home page
    // window.location.href = '/login'; // Or use react-router navigate
  };

  return (
    <AuthContext.Provider value={{ user, token, isAuthenticated: !!user && !!token, isLoading, login, register, logout }}>
      {children}
    </AuthContext.Provider>
  );
};

export const useAuth = (): AuthContextType => {
  const context = useContext(AuthContext);
  if (context === undefined) {
    throw new Error('useAuth must be used within an AuthProvider');
  }
  return context;
};
