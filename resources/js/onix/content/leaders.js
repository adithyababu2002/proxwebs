export const leaderMembers = [
    {
        id: 'sanoof',
        slug: 'sanoof-khan',
        name: 'Dr. Sanoof Khan S N',
        role: 'Founder, Chairman & CEO',
        image: 'sanoof-khan.png',
        shortBio: 'Sets the company vision and leads strategy across product, growth, and long-term direction.',
        bio: 'As Founder, Chairman & CEO, Dr. Sanoof Khan S N leads the company with a clear focus on building technology that helps teams publish faster and with more confidence. He shapes overall strategy, partnerships, and organizational priorities — ensuring product innovation stays grounded in real customer needs and sustainable growth.',
        focus: ['Company vision', 'Strategic leadership', 'Growth & partnerships'],
    },
    {
        id: 'vibin',
        slug: 'vibin-vargis-kurakar',
        name: 'Mr. Vibin Vargis Kurakar',
        role: 'Chief Operating Officer',
        image: 'vibin-vargis-kurakar.png',
        shortBio: 'Leads day-to-day operations and keeps product delivery, customer success, and growth aligned.',
        bio: 'As Chief Operating Officer, Mr. Vibin Vargis Kurakar oversees operations across the organization — aligning teams, processes, and delivery so customers get a reliable, high-quality publishing experience. He focuses on execution excellence, cross-functional coordination, and scaling the company with clarity and accountability.',
        focus: ['Operations', 'Delivery excellence', 'Cross-functional leadership'],
    },
    {
        id: 'adithya',
        slug: 'adithya-babu',
        name: 'Adithya Babu',
        role: 'Project Lead',
        image: 'adithya-babu.png',
        shortBio: 'Leads the Proxwebs CMS project — guiding delivery from product vision to a polished, AI-ready platform.',
        bio: 'As Project Lead, Adithya Babu owns the end-to-end delivery of the Proxwebs CMS. She built the platform from the ground up and continues to guide priorities, architecture, and team execution across the visual editor, reusable sections, templates, real-time publishing, and AI workflows. Balancing hands-on engineering with clear project direction, she keeps the roadmap focused and turns complex publishing challenges into tools that help marketers ship beautiful websites without waiting on developers.',
        focus: ['Project leadership', 'CMS architecture', 'Delivery & product direction'],
    },
];

export const leaderIds = leaderMembers.map((member) => member.id);

export const leadersIntro = {
    eyebrow: 'Our Leaders',
    homeTitle: 'Leadership behind the <em>vision</em>',
    homeSubtitle: 'The people guiding strategy, operations, and the product direction of Proxwebs.',
    pageTitle: 'Meet the leaders shaping Proxwebs',
    pageLead:
        'Our leadership team sets the direction for product, operations, and growth — keeping Proxwebs focused on helping organizations publish with confidence.',
};

export function getLeaderBySlug(slug) {
    return leaderMembers.find((member) => member.slug === slug || member.id === slug) || null;
}

export function getRelatedLeaders(slug, limit = 2) {
    return leaderMembers.filter((member) => member.slug !== slug && member.id !== slug).slice(0, limit);
}
