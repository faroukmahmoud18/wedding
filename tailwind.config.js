/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: 'class', // Matches front them/
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue", // If Vue components are used
    "./app/View/Components/**/*.php", // If using Blade components
    "./app/Livewire/**/*.php", // If using Livewire
  ],
  theme: {
    container: { // Matches front them/
        center: true,
        padding: '2rem',
        screens: {
            '2xl': '1400px'
        }
    },
    extend: {
        fontFamily: { // Matches front them/
            'serif': ['Playfair Display', 'Times New Roman', 'serif'],
            'sans': ['Inter', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'sans-serif'],
        },
        colors: { // Matches front them/ (using HSL variables)
            border: 'hsl(var(--border))',
            input: 'hsl(var(--input))',
            ring: 'hsl(var(--ring))',
            background: 'hsl(var(--background))',
            foreground: 'hsl(var(--foreground))',
            primary: {
                DEFAULT: 'hsl(var(--primary))',
                foreground: 'hsl(var(--primary-foreground))'
            },
            secondary: {
                DEFAULT: 'hsl(var(--secondary))',
                foreground: 'hsl(var(--secondary-foreground))'
            },
            destructive: {
                DEFAULT: 'hsl(var(--destructive))',
                foreground: 'hsl(var(--destructive-foreground))'
            },
            muted: {
                DEFAULT: 'hsl(var(--muted))',
                foreground: 'hsl(var(--muted-foreground))'
            },
            accent: {
                DEFAULT: 'hsl(var(--accent))',
                foreground: 'hsl(var(--accent-foreground))'
            },
            popover: {
                DEFAULT: 'hsl(var(--popover))',
                foreground: 'hsl(var(--popover-foreground))'
            },
            card: {
                DEFAULT: 'hsl(var(--card))',
                foreground: 'hsl(var(--card-foreground))'
            },
            sidebar: { // Matches front them/
                DEFAULT: 'hsl(var(--sidebar-background))',
                foreground: 'hsl(var(--sidebar-foreground))',
                primary: 'hsl(var(--sidebar-primary))',
                'primary-foreground': 'hsl(var(--sidebar-primary-foreground))',
                accent: 'hsl(var(--sidebar-accent))',
                'accent-foreground': 'hsl(var(--sidebar-accent-foreground))',
                border: 'hsl(var(--sidebar-border))',
                ring: 'hsl(var(--sidebar-ring))'
            },
            royal: { // Matches front them/
                gold: 'hsl(var(--royal-gold))',
                'gold-light': 'hsl(var(--royal-gold-light))',
                'gold-dark': 'hsl(var(--royal-gold-dark))',
                ivory: 'hsl(var(--ivory))',
                'warm-ivory': 'hsl(var(--warm-ivory))',
                'deep-brown': 'hsl(var(--deep-brown))'
            }
        },
        borderRadius: { // Matches front them/
            lg: 'var(--radius)',
            md: 'calc(var(--radius) - 2px)',
            sm: 'calc(var(--radius) - 4px)'
        },
        keyframes: { // Matches front them/
            'accordion-down': {
                from: { height: '0' },
                to: { height: 'var(--radix-accordion-content-height)' }
            },
            'accordion-up': {
                from: { height: 'var(--radix-accordion-content-height)' },
                to: { height: '0' }
            }
        },
        animation: { // Matches front them/
            'accordion-down': 'accordion-down 0.2s ease-out',
            'accordion-up': 'accordion-up 0.2s ease-out'
        }
    },
  },
  plugins: [
    require('tailwindcss-animate'), // Matches front them/
    require('@tailwindcss/forms'), // Often useful for Laravel projects
    // require('@tailwindcss/typography'), // If using prose styles
  ],
};
