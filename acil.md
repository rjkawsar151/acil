# PROJECT: ADONIS CHEMICAL LIMITED – CORPORATE WEBSITE + ADMIN CMS

Build a complete, production-ready, modern corporate website and backend CMS for a chemical manufacturing/company brand named:

**ADONIS CHEMICAL LIMITED**

Company details:

- Company Name: Adonis Chemical Limited
- Location: Genda, Savar, Dhaka, Bangladesh
- Parent Organization: Adonis Group
- Brand: SINODA
- Industry: Chemical, personal care, beauty, salon and related chemical/product manufacturing
- Database: MySQL
- Main Brand Color: Blue
- Overall Style: Modern, scientific, premium, industrial, clean and trustworthy

The website must feel like a professional international chemical manufacturing company rather than a generic corporate template.

---

# 1. TECHNOLOGY STACK

Use:

- Laravel 12+
- PHP 8.4+
- MySQL
- Blade
- Tailwind CSS
- Alpine.js where required
- JavaScript
- Laravel Authentication
- Laravel Validation
- Laravel Storage
- MySQL migrations
- Eloquent ORM
- Responsive admin dashboard
- SEO-friendly frontend
- Clean MVC architecture

Use reusable components throughout the project.

Do not hardcode website content that should be editable through the admin dashboard.

---

# 2. DESIGN DIRECTION

Create a premium scientific visual identity.

Primary colors:

- Deep Navy Blue: #071B33
- Corporate Blue: #0B5ED7
- Bright Scientific Blue: #168CFF
- Cyan Accent: #00B7D9
- Light Blue: #EAF5FF
- White: #FFFFFF
- Light Gray: #F6F8FB
- Dark Text: #142033

Use blue gradients such as:

`linear-gradient(135deg, #071B33 0%, #0B5ED7 55%, #00B7D9 100%)`

The overall design should contain:

- generous white space
- clean grids
- premium typography
- subtle gradients
- scientific graphics
- glassmorphism used selectively
- subtle shadows
- smooth hover interactions
- elegant micro animations
- professional industrial photography
- abstract laboratory visuals
- molecular structures
- chemical particles
- transparent liquid effects
- laboratory glassware
- clean manufacturing environments

Avoid making the website look dangerous, toxic, dirty or overly industrial.

The visual identity should communicate:

**Science + Quality + Innovation + Manufacturing + Trust**

---

# 3. TYPOGRAPHY

Use a modern professional font combination.

Recommended:

Headings:
**Manrope / Plus Jakarta Sans / Inter**

Body:
**Inter**

Use strong typography hierarchy.

Headings should be bold but clean.

---

# 4. HEADER

Create a modern sticky header.

Desktop structure:

Logo | Home | About | Products | SINODA | Manufacturing | Quality | Sustainability | News | Contact | Get In Touch

Use dropdown menus where appropriate.

Header should initially look slightly transparent over the hero section.

After scrolling:

- white background
- subtle shadow
- dark navigation text
- sticky positioning

Mobile version should have a premium slide-out menu.

---

# 5. HERO SECTION

Create an impressive full-screen hero section.

Main headline example:

**Science Behind Better Products.**

Supporting text:

**Adonis Chemical Limited combines modern manufacturing, quality-driven processes and continuous innovation to develop reliable chemical and personal care solutions under the SINODA brand.**

CTA buttons:

**Explore Our Products**

**Discover SINODA**

Secondary small text:

**A Concern of Adonis Group**

Add an elegant badge:

**Manufactured in Genda, Savar, Bangladesh**

---

# HERO ANIMATION

The hero section must contain an advanced chemical/scientific animation.

Create a subtle interactive animated scientific environment containing:

- floating molecules
- connected molecular bonds
- transparent particles
- soft glowing blue spheres
- moving chemical structures
- liquid bubbles
- slow particle movement
- subtle laboratory grid
- molecular orbit animations
- light blue energy connections
- transparent floating glass-like circles

Use CSS / Canvas / SVG / Three.js where appropriate.

The animation should feel elegant and professional.

DO NOT create excessive animation that affects readability.

Mouse movement can create a very subtle parallax reaction.

Particles should slowly move in the background.

Some molecular bonds can gently rotate.

Add a glowing abstract chemical sphere or molecule composition on the right side of the hero section.

The visual should look like:

**Advanced Chemical Research + Modern Manufacturing + Premium Technology**

Keep animation optimized for mobile devices.

Use reduced animation complexity on smaller devices.

---

# 6. TRUST / COMPANY STATISTICS SECTION

Immediately below the hero section create animated statistics.

Example:

**Adonis Chemical Limited**

- Quality Focused Manufacturing
- Modern Production Facility
- Professional Product Development
- SINODA Product Portfolio

Create animated counters that can be controlled through the admin dashboard.

Example fields:

Years of Experience  
Products  
Production Capacity  
Business Partners

Admin should be able to customize these statistics.

---

# 7. ABOUT ADONIS CHEMICAL LIMITED

Section heading:

**Where Science Meets Everyday Care**

Create a professional introduction explaining that Adonis Chemical Limited is a concern of Adonis Group and operates from Genda, Savar.

Example:

"Adonis Chemical Limited is a growing chemical and personal care product company committed to combining scientific formulation, controlled manufacturing and consistent product quality. Through our SINODA brand, we develop products designed for professional salon, grooming, beauty and everyday personal care applications."

Add:

- Company image
- Factory image
- laboratory image
- animated decorative molecules

Buttons:

**Learn About Us**

---

# 8. SINODA BRAND SECTION

Create a dedicated premium showcase for:

# SINODA

Headline:

**Professional Care. Developed with Purpose.**

Explain that SINODA is a brand of Adonis Chemical Limited.

Show attractive product cards.

Example product categories:

- Shampoo
- Hair Oil
- Hair Wax
- Hair Removing Wax
- Cleanser
- Body Wash
- Hand Wash
- Massage Oil
- Scrub
- Soothing Gel
- Aloe Vera Gel
- Rose Water
- Shaving Gel
- Shower Gel
- Professional Salon Products

Every product must come dynamically from the database.

Each card should contain:

- Product image
- Product name
- Category
- Short description
- View Product button

Add premium hover effects.

---

# 9. PRODUCT LISTING PAGE

URL:

`/products`

Provide a modern responsive product catalogue.

Features:

- Search products
- Filter by category
- Product grid
- Pagination
- Featured products
- Category filter
- Responsive layout

Product card:

Image  
Category  
Product Name  
Short Description  
View Details

---

# 10. PRODUCT DETAILS PAGE

URL:

`/products/{slug}`

Design a high-end product detail page.

Include:

- Product gallery
- Product name
- Category
- Short description
- Full description
- Product benefits
- Available sizes
- Applications
- Usage information
- Ingredients / formulation information where applicable
- Packaging details
- Product code / SKU
- Download brochure option
- Related products
- Inquiry button

Do not show sensitive manufacturing formulas.

---

# 11. PRODUCT CATEGORY SYSTEM

Create category CRUD.

Examples:

Hair Care  
Skin Care  
Body Care  
Salon Professional  
Grooming  
Cleansing  
Wellness  
Personal Care

Database:

categories

Fields:

id  
name  
slug  
description  
image  
status  
sort_order  
created_at  
updated_at

---

# 12. PRODUCTS DATABASE

Create `products` table.

Fields:

id  
category_id  
name  
slug  
sku  
short_description  
description  
benefits  
usage_information  
ingredients_information  
packaging_information  
available_sizes  
featured_image  
brochure  
is_featured  
status  
meta_title  
meta_description  
sort_order  
created_at  
updated_at

Create separate table:

product_images

Fields:

id  
product_id  
image  
sort_order  
created_at  
updated_at

---

# 13. MANUFACTURING SECTION

Create a strong manufacturing page.

URL:

`/manufacturing`

Headline:

**Manufacturing with Precision**

Use professional visual sections showing:

1. Raw Material Selection
2. Formulation & Development
3. Controlled Production
4. Quality Inspection
5. Filling & Packaging
6. Final Product Assessment
7. Distribution

Create an animated process flow.

Example visual:

Raw Materials → Development → Production → Quality Control → Packaging → Finished Product

Use interactive line animations.

---

# 14. QUALITY CONTROL PAGE

URL:

`/quality`

Headline:

**Quality at Every Stage**

Explain the company's commitment to quality assurance.

Create sections such as:

- Raw Material Assessment
- Process Control
- Batch Monitoring
- Product Inspection
- Packaging Assessment
- Storage & Handling
- Continuous Improvement

Include modern laboratory imagery.

Create premium icon cards.

---

# 15. RESEARCH & DEVELOPMENT SECTION

Create section:

**Innovation Through Research**

Explain product research and formulation development.

Visual direction:

- scientist/laboratory environment
- molecule diagrams
- formulation containers
- scientific data graphics
- clean laboratory visuals

Add subtle animated molecule background.

---

# 16. INDUSTRIES / APPLICATIONS

Create dynamic application cards.

Examples:

**Professional Salons**

Solutions developed for professional grooming and beauty environments.

**Personal Care**

Products designed for everyday personal care requirements.

**Beauty & Wellness**

Beauty and wellness-oriented formulations.

**Institutional Requirements**

Product solutions designed according to commercial requirements.

Admin should manage applications through CRUD.

---

# 17. SUSTAINABILITY PAGE

URL:

`/sustainability`

Headline:

**Responsible Growth**

Create sections around:

- Efficient Manufacturing
- Responsible Resource Usage
- Product Optimization
- Waste Awareness
- Better Packaging
- Continuous Process Improvement

Do not make unverifiable environmental claims.

All sustainability claims must be editable through admin.

---

# 18. ADONIS GROUP SECTION

Create a section:

**A Concern of Adonis Group**

Explain that Adonis Chemical Limited operates as part of the wider Adonis Group business ecosystem.

Use an elegant corporate design.

Admin should be able to edit this content.

---

# 19. WHY CHOOSE US

Create six premium cards:

**Quality Focus**

Consistent attention to product quality.

**Professional Manufacturing**

Organized manufacturing processes.

**Continuous Development**

Products improved through research and market requirements.

**Reliable Products**

Solutions created for professional and consumer applications.

**Growing Portfolio**

Expanding SINODA product categories.

**Customer Focus**

Product development aligned with real market requirements.

---

# 20. PRODUCT PROCESS ANIMATION

Create a visual section with animated steps:

IDEA  
↓  
RESEARCH  
↓  
FORMULATION  
↓  
TESTING  
↓  
PRODUCTION  
↓  
QUALITY CONTROL  
↓  
PACKAGING  
↓  
PRODUCT

Animate connecting lines as the user scrolls.

---

# 21. NEWS / BLOG

Create dynamic blog system.

Frontend:

`/news`

Details:

`/news/{slug}`

Categories can include:

Company News  
Product Updates  
Industry Insights  
SINODA Updates  
Manufacturing  
Research

Blog fields:

id  
title  
slug  
excerpt  
content  
featured_image  
author  
category_id  
published_at  
status  
meta_title  
meta_description  
created_at  
updated_at

---

# 22. CONTACT PAGE

URL:

`/contact`

Design a modern contact page.

Display:

**Adonis Chemical Limited**

Genda, Savar, Dhaka, Bangladesh

Add dynamic:

Phone  
Email  
Website  
Office Address  
Factory Address  
Google Map  
Working Hours

Contact form fields:

Name  
Company  
Phone  
Email  
Subject  
Message

Store all inquiries in database.

Admin must be able to:

- view inquiry
- mark as read
- mark as replied
- archive inquiry
- delete inquiry

---

# 23. PRODUCT INQUIRY

Each product page should contain:

**Request Product Information**

Fields:

Name  
Company  
Phone  
Email  
Product  
Quantity / Requirement  
Message

Store inquiry in database.

Admin can view inquiries.

---

# 24. FOOTER

Create premium dark navy footer.

Columns:

Company

- About
- Manufacturing
- Quality
- Sustainability

Products

- Product Categories
- SINODA
- Featured Products

Resources

- News
- Downloads
- Contact

Contact

Adonis Chemical Limited  
Genda, Savar, Dhaka, Bangladesh

Bottom:

**© Adonis Chemical Limited. All Rights Reserved.**

Add:

**A Concern of Adonis Group**

Add social icons dynamically from admin.

---

# 25. ADMIN DASHBOARD

Create secure admin route:

`/admin`

Login:

`/admin/login`

Create professional blue admin interface.

Sidebar:

Dashboard

Website Management
- Homepage
- About
- Company Information

Products
- Products
- Categories
- Product Images

SINODA
- Brand Information

Manufacturing
- Manufacturing Sections

Quality
- Quality Content

Applications
- Industries / Applications

Content
- Pages
- Blog
- Blog Categories

Media
- Media Library

Communication
- Contact Messages
- Product Inquiries

Website
- Navigation
- Footer
- SEO
- Social Links

Administration
- Users
- Roles & Permissions
- Settings

---

# 26. ADMIN DASHBOARD HOME

Create statistics cards:

Total Products  
Product Categories  
Total Inquiries  
Unread Messages  
Published Blogs  
Draft Blogs

Create graphs:

Monthly Website Inquiries

Product Inquiry Distribution

Recent activity section.

Recent messages.

Recently added products.

---

# 27. CRUD OPERATIONS

Implement complete CRUD operations for:

Products

Categories

Product Images

Pages

Homepage Sections

Blog Posts

Blog Categories

Applications

Manufacturing Sections

Quality Sections

Statistics

Contact Messages

Product Inquiries

Social Links

Navigation

Company Information

Website Settings

SEO Settings

Admin Users

Roles

Permissions

All CRUD operations should include:

Create  
Read  
Update  
Delete  
Search  
Pagination  
Status Change

Use confirmation modal before deleting.

---

# 28. MEDIA LIBRARY

Create simple media manager.

Features:

Upload Images  
Preview Images  
Delete Images  
Copy Image URL  
Search Media

Folders can optionally include:

Products  
Blog  
Company  
Factory  
Homepage

Validate file type and size.

---

# 29. WEBSITE SETTINGS

Create settings table.

Admin editable settings:

Company Name  
Logo  
Favicon  
SINODA Logo  
Adonis Group Logo  
Phone  
Email  
Website  
Office Address  
Factory Address  
Google Maps Embed  
Facebook  
LinkedIn  
Instagram  
YouTube  
Footer Description  
Copyright Text

---

# 30. HOMEPAGE CMS

Admin should control homepage sections.

Allow administrators to:

- enable/disable section
- edit heading
- edit description
- upload image
- modify button labels
- change button URLs
- reorder sections

Use `sort_order`.

---

# 31. SEO MANAGEMENT

Each editable page should support:

Meta Title  
Meta Description  
Meta Keywords  
OG Image  
Canonical URL where needed

Generate:

`robots.txt`

`sitemap.xml`

Use clean SEO-friendly URLs.

Add structured data where appropriate:

Organization  
Product  
Breadcrumb  
Article

---

# 32. ROLE BASED ACCESS CONTROL

Create roles:

Super Admin  
Admin  
Content Manager  
Product Manager

Super Admin:

Full Access

Admin:

Most CMS functions

Content Manager:

Pages and Blogs

Product Manager:

Products and Categories

Permissions must control:

view  
create  
edit  
delete

---

# 33. DATABASE TABLES

Create migrations for at least:

users  
roles  
permissions  
role_user / appropriate pivot tables  
categories  
products  
product_images  
applications  
pages  
homepage_sections  
company_statistics  
manufacturing_sections  
quality_sections  
blog_categories  
blogs  
contact_messages  
product_inquiries  
media  
social_links  
navigation_items  
settings  
seo_settings

Use foreign keys properly.

Use indexes where appropriate.

---

# 34. PRODUCT IMAGE SYSTEM

Use Laravel storage.

Save product images under:

`storage/app/public/products`

Generate public storage link.

Support:

featured image

multiple gallery images

image deletion

image replacement

WebP where possible.

---

# 35. SECURITY

Implement:

CSRF protection

Form validation

XSS-safe Blade output

Authentication middleware

Admin middleware

Authorization policies

File upload validation

Rate limiting on public forms

Secure password hashing

Database validation

Do not expose sensitive system information.

---

# 36. CONTACT SPAM PROTECTION

Implement:

Laravel rate limiter

honeypot field

server-side validation

Optionally design architecture so reCAPTCHA can be added later.

---

# 37. RESPONSIVE DESIGN

Optimize for:

1920 desktop

1440 desktop

1366 laptop

1024 tablet

768 tablet

430 mobile

390 mobile

360 mobile

All pages must be fully responsive.

---

# 38. ANIMATION SYSTEM

Use subtle premium animations.

Examples:

fade up

slide reveal

molecular rotation

floating particles

liquid bubbles

counter animation

card hover

button hover

image reveal

scroll-triggered animations

section transition

Use CSS animations, Intersection Observer and JavaScript.

Use Three.js only where it genuinely improves the hero animation.

Animations must remain performant.

---

# 39. CHEMICAL VISUAL LANGUAGE

Use decorative scientific visuals including:

molecular structures

hexagonal chemistry structures

atoms

chemical bonds

laboratory glass

droplets

particles

transparent liquid shapes

microscopic-inspired circles

scientific grids

formula-inspired graphics

Do not overcrowd pages.

Use these as premium background details.

---

# 40. HOMEPAGE ORDER

Homepage should follow this sequence:

1. Header
2. Hero with chemical animation
3. Company Statistics
4. About Adonis Chemical Limited
5. SINODA Brand Showcase
6. Featured Products
7. Product Categories
8. Manufacturing Process
9. Quality Assurance
10. Research & Development
11. Industries / Applications
12. Why Choose Us
13. Sustainability
14. Adonis Group
15. Latest News
16. Inquiry CTA
17. Footer

---

# 41. CTA SECTION

Before footer create a large blue CTA.

Headline:

**Looking for Reliable Product Solutions?**

Description:

Connect with Adonis Chemical Limited to learn more about our SINODA product portfolio and manufacturing capabilities.

Buttons:

**Contact Us**

**Explore Products**

Use animated molecule graphics in background.

---

# 42. SEARCH

Create frontend search.

Search:

Products  
News  
Pages

Route:

`/search?q=`

Display grouped search results.

---

# 43. BREADCRUMBS

Create breadcrumbs for internal pages.

Example:

Home > Products > Hair Care > Shampoo

Use structured data.

---

# 44. EMPTY STATES

Create polished empty states for admin dashboard.

Example:

"No products have been added yet."

Button:

"Add First Product"

Do not leave blank tables.

---

# 45. ADMIN TABLE DESIGN

Every admin listing should contain:

Search input

Filter

Status filter

Create button

Table

Pagination

Action dropdown

Actions:

View  
Edit  
Delete

Use responsive table design.

---

# 46. FORM UX

Admin forms should use clear cards.

Sections such as:

Basic Information

Product Content

Media

SEO

Publication Settings

Use validation messages below fields.

Preserve submitted input after validation errors.

---

# 47. SLUG MANAGEMENT

Automatically generate slugs from names/titles.

Allow admin to edit slug manually.

Ensure slug uniqueness.

---

# 48. STATUS SYSTEM

Use statuses such as:

Active  
Inactive

For blog/pages:

Draft  
Published

Use badges in admin tables.

---

# 49. SOFT DELETE

Use Laravel SoftDeletes for important content such as:

Products  
Blogs  
Pages

Optionally provide trash management in admin.

---

# 50. DATABASE SEEDING

Create realistic demo seeders.

Seed:

Admin user

Product categories

SINODA sample products

Company settings

Homepage content

Sample blogs

Applications

Manufacturing sections

Quality sections

Do not use Lorem Ipsum.

Use realistic Adonis Chemical Limited / SINODA content.

---

# 51. CODE QUALITY

Follow:

Laravel conventions

Service-oriented code where appropriate

Form Request validation

Policies

Route model binding

Reusable Blade components

Repository abstraction only if genuinely useful

Keep code readable and maintainable.

Do not over-engineer.

---

# 52. PERFORMANCE

Optimize:

Images

Lazy loading

Database queries

Eager loading

CSS/JS bundle

Animations

Caching where appropriate

Use pagination for large datasets.

Target strong Lighthouse scores.

---

# 53. ACCESSIBILITY

Add:

semantic HTML

alt text

keyboard navigation

visible focus states

sufficient contrast

ARIA labels when necessary

---

# 54. FINAL RESULT

The final website should visually communicate:

**Adonis Chemical Limited**

**Science. Quality. Innovation.**

**Home of SINODA**

**A Concern of Adonis Group**

It should look comparable to a modern international chemical, cosmetic formulation or personal-care manufacturing company.

The frontend must feel premium and trustworthy.

The backend should function as a proper CMS where the company team can manage the website without modifying source code.

The entire application must be:

- production ready
- responsive
- secure
- database driven
- easy to maintain
- SEO friendly
- visually modern
- professional
- scalable

Create the full project systematically, including migrations, models, controllers, requests, policies, routes, Blade views, Tailwind styles, JavaScript animations, admin dashboard and seed data.

Do not only create static HTML.

Build the complete working Laravel + MySQL web application.