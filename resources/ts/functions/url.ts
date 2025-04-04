import { route } from 'ziggy-js';

export function ozzieProjectUrl(packageName: string): string {
    const [vendor, name] = packageName.split('/');
    return route('projects.show', { vendor, name });
}

export function urlForType(packageName: string, type: string, id: number): string {
    const [vendor, name] = packageName.split('/');
    return route(`${type}.show`, { vendor, name, id });
}
