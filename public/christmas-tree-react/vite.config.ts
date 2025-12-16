import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';

// https://vitejs.dev/config/
export default defineConfig({
  base: './', // Relative path for Laravel integration
  root: './',
  build: {
    outDir: 'dist',
    chunkSizeWarningLimit: 1500,
  },
  plugins: [react()],
});
