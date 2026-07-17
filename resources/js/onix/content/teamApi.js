import axios from 'axios';
import { teamMembers as fallbackMembers, teamIntro } from '../content/team';
import { leaderIds, leaderMembers } from '../content/leaders';

export { teamIntro };

const leaderNameKeys = leaderMembers.map((member) =>
    String(member.name)
        .toLowerCase()
        .replace(/[^a-z]/g, '')
);

function isLeader(member) {
    const id = String(member?.id || '').toLowerCase();
    const slug = String(member?.slug || '').toLowerCase();
    if (leaderIds.includes(id) || leaderIds.includes(slug)) {
        return true;
    }

    const nameKey = String(member?.name || '')
        .toLowerCase()
        .replace(/[^a-z]/g, '');

    return leaderNameKeys.some((key) => nameKey.includes(key) || key.includes(nameKey));
}

function withoutLeaders(members) {
    return members.filter((member) => !isLeader(member));
}

export async function fetchTeamMembers() {
    try {
        const { data } = await axios.get('/api/team');
        const members = Array.isArray(data?.data) ? data.data : [];
        const filtered = withoutLeaders(members);
        return filtered.length ? filtered : withoutLeaders(fallbackMembers);
    } catch {
        return withoutLeaders(fallbackMembers);
    }
}
