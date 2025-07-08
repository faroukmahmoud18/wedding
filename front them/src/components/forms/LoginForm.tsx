import { zodResolver } from "@hookform/resolvers/zod";
import { useForm } from "react-hook-form";
import * as z from "zod";
import { Button } from "@/components/ui/button";
import {
  Form,
  FormControl,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
} from "@/components/ui/form";
import { Input } from "@/components/ui/input";
import { useAuth } from "@/hooks/useAuth";
import { useState } from "react";
import { toast } from "@/components/ui/use-toast";
import { RoyalCrown } from "@/components/RoyalMotifs";
import { Link, useNavigate } from "react-router-dom";

const loginFormSchema = z.object({
  email: z.string().email({ message: "Please enter a valid email address." }),
  password: z.string().min(1, { message: "Password is required." }), // Min 1 for presence, actual length validation by backend
});

type LoginFormValues = z.infer<typeof loginFormSchema>;

export function LoginForm() {
  const { login } = useAuth();
  const navigate = useNavigate();
  const [isLoading, setIsLoading] = useState(false);
  const [error, setError] = useState<string | null>(null);

  const form = useForm<LoginFormValues>({
    resolver: zodResolver(loginFormSchema),
    defaultValues: {
      email: "",
      password: "",
    },
  });

  async function onSubmit(data: LoginFormValues) {
    setIsLoading(true);
    setError(null);
    try {
      await login(data);
      toast({
        title: "Login Successful!",
        description: (
          <div className="flex items-center">
            <RoyalCrown className="text-primary mr-2 h-5 w-5" />
            <span>Welcome back to Royal Vows! Redirecting...</span>
          </div>
        ),
        className: "bg-gradient-to-r from-primary to-primary/90 text-primary-foreground",
      });
      // Redirect to dashboard or intended page after login
      // For now, let's redirect to dashboard. This might need to be more sophisticated later.
      navigate("/dashboard");
    } catch (err) {
      let errorMessage = "Login failed. Please check your credentials.";
      if (err instanceof Error) {
        errorMessage = err.message;
      } else if (typeof err === 'string') {
        errorMessage = err;
      }
      setError(errorMessage);
      toast({
        variant: "destructive",
        title: "Login Failed",
        description: errorMessage,
      });
    } finally {
      setIsLoading(false);
    }
  }

  return (
    <Form {...form}>
      <form onSubmit={form.handleSubmit(onSubmit)} className="space-y-6">
        {error && <p className="text-sm font-medium text-destructive bg-destructive/10 p-3 rounded-md">{error}</p>}
        <FormField
          control={form.control}
          name="email"
          render={({ field }) => (
            <FormItem>
              <FormLabel>Email Address</FormLabel>
              <FormControl>
                <Input type="email" placeholder="e.g., yourmajesty@royalvows.com" {...field} />
              </FormControl>
              <FormMessage />
            </FormItem>
          )}
        />
        <FormField
          control={form.control}
          name="password"
          render={({ field }) => (
            <FormItem>
              <FormLabel>Password</FormLabel>
              <FormControl>
                <Input type="password" placeholder="Enter your password" {...field} />
              </FormControl>
              <FormMessage />
            </FormItem>
          )}
        />
        <div className="flex items-center justify-between">
            <Link to="/forgot-password" /* Placeholder for forgot password page */ className="text-sm text-primary hover:underline">
                Forgot password?
            </Link>
        </div>
        <Button type="submit" className="w-full btn-royal text-lg py-3" disabled={isLoading}>
          {isLoading ? "Signing In..." : "Sign In"}
        </Button>
      </form>
    </Form>
  );
}
