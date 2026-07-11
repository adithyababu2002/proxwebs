import axios from 'axios';
import { teamMembers as fallbackMembers, teamIntro } from '../content/team';

export { teamIntro };

export async function fetchTeamMembers() {
    try {
        const { data } = await axios.get('/api/team');
        const members = Array.isArray(data?.data) ? data.data : [];
        return members.length ? members : fallbackMembers;
    } catch {
        return fallbackMembers;
    }
}
