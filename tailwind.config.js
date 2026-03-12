module.exports = {
  content: ['./templates/**/*.twig'],
  theme: {
    extend: {
      colors: {
        'deep-bg': '#080d19',
        'panel-bg': '#0d1628',
        'panel-border': '#1c3050',
        'accent-sky': '#38bdf8',
        'accent-indigo': '#818cf8',
        'accent-emerald': '#34d399',
        'text-primary': '#e2e8f0',
        'text-secondary': '#94a3b8',
      },
      fontFamily: {
        display: ['Syne', 'sans-serif'],
        body: ['DM Sans', 'sans-serif'],
        mono: ['JetBrains Mono', 'monospace'],
      },
    },
  },
  plugins: [],
}
