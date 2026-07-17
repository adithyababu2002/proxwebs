export const designsIntro = {
    eyebrow: 'Designs',
    pageTitle: 'Preview ready-made website designs before you apply them',
    pageLead:
        'Choose from polished templates built for fast page styling. Open any design to inspect the full preview, compare layouts, and pick the look that fits your brand.',
};

export const designs = [
    {
        id: 'default',
        name: 'Aurora',
        accent: '#f7941d',
        tagline: 'Classic orange layout',
        description:
            'The original CENFADA layout with bold orange service blocks, dark analytics imagery, and a complete long-page structure.',
        image: 'templates/default.jpg',
    },
    {
        id: 'template-g',
        name: 'Velvet',
        accent: '#6b8f71',
        tagline: 'Olive dark editorial',
        description:
            'A premium black and olive treatment with serif headings, calm achievement bands, and distinguished service cards.',
        image: 'templates/template-g.jpg',
    },
    {
        id: 'template-a',
        name: 'Opal',
        accent: '#007a68',
        tagline: 'Mint corporate clarity',
        description:
            'A clean light-green design with balanced sections, compact service rows, and a professional training-center feel.',
        image: 'templates/template-a.jpg',
    },
    {
        id: 'template-f',
        name: 'Elysian',
        accent: '#2f8cff',
        tagline: 'Modern deep blue',
        description:
            'A dark SaaS-inspired page with rounded cards, electric blue buttons, and a compact hero built for modern tech brands.',
        image: 'templates/template-f.jpg',
    },
    {
        id: 'template-b',
        name: 'Royale',
        accent: '#6757ff',
        tagline: 'Navy product style',
        description:
            'A spacious navy-and-white design with product-style cards, centered content blocks, and crisp purple actions.',
        image: 'templates/template-b.jpg',
    },
    {
        id: 'template-d',
        name: 'Elite',
        accent: '#84b99f',
        tagline: 'Soft wave design',
        description:
            'A light, friendly version with curved wave dividers, sage accents, rounded sections, and gentle content flow.',
        image: 'templates/template-d.jpg',
    },
    {
        id: 'template-e',
        name: 'Luxe',
        accent: '#f6a915',
        tagline: 'Navy and amber',
        description:
            'A high-contrast navy design with amber stat bands, sharp section titles, and a strong institutional tone.',
        image: 'templates/template-e.jpg',
    },
    {
        id: 'template-c',
        name: 'Signature',
        accent: '#4856d9',
        tagline: 'Pale blue refined',
        description:
            'A refined pale-blue template with editorial spacing, slim dividers, and elegant content sections.',
        image: 'templates/template-c.jpg',
    },
];

export function getDesignById(id) {
    return designs.find((design) => design.id === id) || null;
}
