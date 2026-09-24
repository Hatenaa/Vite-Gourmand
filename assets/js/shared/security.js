/** Formatage anti-XSS */

export function escapeHtml(value) {
    if (value === null || value === undefined) return '';
    return String(value)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
}

/** Empêche les injections type javascript: ou path traversal dans un href/src. */

export function escapeUrlSegment(value) {
    if (value === null || value === undefined) return '';
    
    const str = String(value).trim();

    if (/^\s*javascript:/i.test(str)) return '';
    if (/^\s*vbscript:/i.test(str)) return '';
    if (/^\s*data:/i.test(str) && !/^data:image\//i.test(str)) return '';

    return str
        .replace(/&/g, '&amp;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');

}

/** Retourner un nombre sûr à injecter dans le code HTML */

export function toSafeNumber(value, fallback = 0) {
    const n = Number(value);
    return Number.isFinite(n) ? n : fallback;
}