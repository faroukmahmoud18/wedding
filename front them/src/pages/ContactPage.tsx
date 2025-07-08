import { Layout } from "@/components/Layout";
import { RoyalOrnament, RoyalBorder, FleurDeLis } from "@/components/RoyalMotifs";
import { ContactForm } from "@/components/forms/ContactForm";
import { Phone, Mail, MapPin } from "lucide-react";

const ContactPage = () => {
  return (
    <Layout>
      <div className="container mx-auto px-4 py-16">
        <div className="text-center mb-12">
          <div className="flex justify-center mb-6">
            <RoyalOrnament className="text-primary" size={48} />
          </div>
          <h1 className="font-serif text-4xl sm:text-5xl font-bold text-royal-deep-brown mb-4">
            Contact Royal Vows
          </h1>
          <p className="text-lg text-muted-foreground max-w-2xl mx-auto">
            We're here to assist you with any inquiries. Reach out to us through the form below or via our contact details.
            Your dream wedding planning starts with a conversation.
          </p>
           <div className="flex justify-center mt-6">
            <RoyalBorder className="text-primary" width={200} height={1} />
          </div>
        </div>

        <div className="grid md:grid-cols-5 gap-12 items-start">
          <div className="md:col-span-3">
            <h2 className="font-serif text-2xl text-royal-deep-brown mb-6 flex items-center">
                <FleurDeLis className="text-primary mr-3" size={24} /> Send Us a Message
            </h2>
            <div className="bg-card p-8 rounded-xl shadow-elegant">
              <ContactForm />
            </div>
          </div>
          <div className="md:col-span-2 space-y-8 pt-0 md:pt-16">
            <h3 className="font-serif text-2xl text-royal-deep-brown mb-2 flex items-center">
                <FleurDeLis className="text-primary mr-3" size={24} /> Our Royal Address
            </h3>
            <div className="space-y-4 text-muted-foreground">
                <div className="flex items-start">
                    <MapPin className="h-6 w-6 mr-4 text-primary flex-shrink-0 mt-1" />
                    <div>
                        <span className="font-semibold text-foreground">Royal Vows Headquarters</span><br/>
                        123 Coronation Street,<br/>
                        Majestic City, Kingdom of Bliss, 12345
                    </div>
                </div>
                 <div className="flex items-center">
                    <Phone className="h-5 w-5 mr-4 text-primary flex-shrink-0" />
                    <a href="tel:+1234567890" className="hover:text-primary">(123) 456-7890</a>
                </div>
                <div className="flex items-center">
                    <Mail className="h-5 w-5 mr-4 text-primary flex-shrink-0" />
                    <a href="mailto:contact@royalvows.com" className="hover:text-primary">contact@royalvows.com</a>
                </div>
            </div>
            <div className="mt-6 pt-6 border-t border-border">
                 <h4 className="font-serif text-lg text-royal-deep-brown mb-2">Office Hours</h4>
                 <p className="text-sm text-muted-foreground">Monday - Friday: 9:00 AM - 6:00 PM</p>
                 <p className="text-sm text-muted-foreground">Saturday: 10:00 AM - 4:00 PM (By Appointment)</p>
                 <p className="text-sm text-muted-foreground">Sunday: Closed for Royal Festivities</p>
            </div>
          </div>
        </div>
      </div>
    </Layout>
  );
};

export default ContactPage;
