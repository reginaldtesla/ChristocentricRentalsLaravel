<?php

return [

  /** Canonical folder for slug-based product filenames. */
  'products_dir' => 'storage/products',

  /**
   * or the auto-picker chose a composite / wrong file.
   */
  /**
   * Manual image overrides when the clone has no good primary asset
   * or the auto-picker chose a composite / wrong file.
   * Cleared after images:rename-products copies each product to storage/products/{slug}.{ext}.
   */
  'overrides' => [
      'atem-mini-pro' => 'storage/2024/10/Blackmagic-ATEM-Mini-Pro-ISO-Top.webp',
      'dji-ronin-r4-pro' => 'storage/2025/01/DJI-Ronin-RS4-Pro-Combo-Gimbal.webp',
      'canon-r6-with-ef-adaptor' => 'storage/2024/10/CanonEOSR6adapter-1.jpg',
  ],

  /**
   * Never use these as a product photo (site logo, placeholders).
   */
  'brand_patterns' => [
      '/cropped-Christocentric/i',
      '/Christocentric-Rentals-logo/i',
      '/woocommerce-placeholder/i',
      '/^logo[-.]/i',
  ],

  /**
   * Skip transparent cutouts for these sources — composites, placeholders,
   * or generic downloads that break apart when background is removed.
   */
  'no_cutout_patterns' => [
      '/with_vaxis/i',
      '/with-vaxis/i',
      '/shopping/i',
      '/^download/i',
      '/collage/i',
      '/cropped-Christocentric/i',
      '/Christocentric-Rentals-logo/i',
      '/woocommerce-placeholder/i',
      '/^logo[-.]/i',
  ],

  /** Skip cutouts on very wide images (multi-item kit photos). */
  'no_cutout_min_aspect_ratio' => 2.1,

];
