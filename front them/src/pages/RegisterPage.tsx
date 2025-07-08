import { Layout } from "@/components/Layout";
import { RegisterForm } from "@/components/forms/RegisterForm";
import { RoyalOrnament, RoyalBorder } from "@/components/RoyalMotifs";
import { Card, CardContent, CardDescription, CardHeader, CardTitle, CardFooter } from "@/components/ui/card";
import { Link } from "react-router-dom";

const RegisterPage = () => {
  return (
    <Layout>
      <div className="container mx-auto px-4 py-16 flex flex-col items-center justify-center min-h-[calc(100vh-15rem)]">
        <div className="text-center mb-8">
          <div className="flex justify-center mb-4">
            <RoyalOrnament className="text-primary" size={40} />
          </div>
          <h1 className="font-serif text-4xl sm:text-5xl font-bold text-royal-deep-brown">
            Join Royal Vows
          </h1>
           <p className="text-lg text-muted-foreground mt-2">
            Create your account to begin planning your majestic wedding or offering your esteemed services.
          </p>
          <div className="flex justify-center mt-4">
            <RoyalBorder className="text-primary" width={150} height={1} />
          </div>
        </div>

        <Card className="w-full max-w-lg shadow-elegant card-royal"> {/* Max-w-lg for wider form */}
          <CardHeader>
            <CardTitle className="font-serif text-2xl text-center text-royal-deep-brown">Create Your Account</CardTitle>
            {/* <CardDescription className="text-center">Fill in the details below to register.</CardDescription> */}
          </CardHeader>
          <CardContent>
            <RegisterForm />
          </CardContent>
          <CardFooter className="flex flex-col items-center space-y-2 pt-6">
            <p className="text-sm text-muted-foreground">
              Already have an account?{" "}
              <Link to="/login" className="font-medium text-primary hover:underline">
                Sign In
              </Link>
            </p>
          </CardFooter>
        </Card>
      </div>
    </Layout>
  );
};

export default RegisterPage;
