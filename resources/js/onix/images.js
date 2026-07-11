export function img(file) {
    if (!file) {
        return '/onix/assets/images/LOGO10.png';
    }

    if (file.startsWith('http://') || file.startsWith('https://') || file.startsWith('/')) {
        return file;
    }

    return `/onix/assets/images/${file}`;
}

export function teamImage(member) {
    if (member?.image_url) {
        return member.image_url;
    }

    return img(member?.image);
}
