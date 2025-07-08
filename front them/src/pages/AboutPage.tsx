import { Layout } from "@/components/Layout";
import { RoyalOrnament } from "@/components/RoyalMotifs";

const AboutPage = () => {
  return (
    <Layout>
      <div className="container mx-auto px-4 py-16 text-center">
        <div className="flex justify-center mb-6">
          <RoyalOrnament className="text-primary" size={48} />
        </div>
        <h1 className="font-serif text-4xl sm:text-5xl font-bold text-royal-deep-brown mb-8">
          About Royal Vows
        </h1>
        <div className="max-w-3xl mx-auto text-lg text-muted-foreground space-y-6">
          <p>
            Welcome to Royal Vows, your premier destination for discovering and booking exquisite wedding services.
            Our mission is to connect discerning couples with the finest vendors, ensuring every wedding is a masterpiece
            of elegance and unforgettable moments.
          </p>
          <p>
            Founded on the principle that your special day deserves nothing but the best, Royal Vows meticulously curates
            a selection of top-tier photographers, breathtaking venues, renowned bridal designers, and talented makeup artists.
            We believe in quality, luxury, and personalized experiences.
          </p>
          <p>
            Our platform is designed to simplify your wedding planning journey, providing you with a seamless and inspiring
            way to find and secure the perfect elements for your celebration. From grand royal affairs to intimate chic gatherings,
            Royal Vows is dedicated to helping you craft the wedding of your dreams.
          </p>
          <div className="flex justify-center mt-10">
            <RoyalOrnament className="text-primary" size={32} />
          </div>
        </div>
      </div>
    </Layout>
  );
};

export default AboutPage;
