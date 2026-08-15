/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        'ocean-sky': '#E0F2FE',
        'ocean-light': '#F0F9FF',
        'sand-warm': '#FFFBEB',
        'teal-ink': '#0B2027',
        'teal-deep': '#0F3D3E',
        'teal-ocean': '#0284C7',
        'starboard': '#10B981',
        'starboard-light': '#ECFDF5',
        'port': '#EF4444',
        'port-light': '#FEF2F2',
        'amber-brass': '#D97706',
        'amber-light': '#FFFBEB',
        brand: {
          50: '#F0F9FF',
          100: '#E0F2FE',
          200: '#BAE6FD',
          500: '#0284C7',
          600: '#0369A1',
          700: '#075985',
          900: '#0C4A6E',
        },
        emerald: {
          500: '#10B981',
          600: '#059669',
        },
        sgred: '#EF4444',
      },
      fontFamily: {
        sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
        display: ['Space Grotesk', 'Inter', 'system-ui', 'sans-serif'],
      }
    },
  },
  plugins: [],
}
