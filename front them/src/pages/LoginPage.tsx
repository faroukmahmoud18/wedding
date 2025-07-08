import { Layout } from "@/components/Layout";
import { LoginForm } from "@/components/forms/LoginForm";
import { RoyalOrnament, RoyalBorder } from "@/components/RoyalMotifs";
import { Card, CardContent, CardDescription, CardHeader, CardTitle, CardFooter } from "@/components/ui/card";
import { Link } from "react-router-dom";

const LoginPage = () => {
  return (
    <Layout>
      <div className="container mx-auto px-4 py-16 flex flex-col items-center justify-center min-h-[calc(100vh-15rem)]"> {/* Adjust min-height as needed */}
        <div className="text-center mb-8">
          <div className="flex justify-center mb-4">
            <RoyalOrnament className="text-primary" size={40} />
          </div>
          <h1 className="font-serif text-4xl sm:text-5xl font-bold text-royal-deep-brown">
            Welcome Back
          </h1>
           <p className="text-lg text-muted-foreground mt-2">
            Sign in to continue your royal journey.
          </p>
          <div className="flex justify-center mt-4">
            <RoyalBorder className="text-primary" width={150} height={1} />
          </div>
        </div>

        <Card className="w-full max-w-md shadow-elegant card-royal">
          <CardHeader>
            <CardTitle className="font-serif text-2xl text-center text-royal-deep-brown">Sign In to Royal Vows</CardTitle>
            {/* <CardDescription className="text-center">Enter your credentials below.</CardDescription> */}
          </CardHeader>
          <CardContent>
            <LoginForm />
          </CardContent>
          <CardFooter className="flex flex-col items-center space-y-2 pt-6">
            <p className="text-sm text-muted-foreground">
              Don't have an account?{" "}
              <Link to="/register" className="font-medium text-primary hover:underline">
                Sign Up
              </Link>
            </p>
          </CardFooter>
        </Card>
      </div>
    </Layout>
  );
};

export default LoginPage;
