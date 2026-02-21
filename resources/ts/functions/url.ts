import route from 'ziggy-js';

export function ozzieProjectUrl(vendor: string, name: string): string {
    return route('projects.show', { vendor, name });
}

export function urlForType(
    vendor: string,
    name: string,
    type: string,
    id: number
): string {
    return route(`${type}.show`, { vendor, name, id });
}
