/* eslint-disable camelcase */

declare global {
    interface Window { githubToken: any; }
}

window.githubToken = window.githubToken || undefined;

export declare type Label = {
    color: string,
    name: string,
}

export declare type User = {
    html_url: URL,
    login: string,
}

export declare type BaseIssue = {
    number: number,
    html_url: URL,
    title: string,
    body: string,
    labels: Label[],
    user: User,
    created_at: string,
}

export declare interface Issue extends BaseIssue {
    pull_request: string,
}

export declare interface PullRequest extends BaseIssue{
    node_id: string,
    draft: boolean
}

export declare type Project = {
    id: number,
    namespace: string,
    name: string,
    packagist_name: string,
    maintainers: Array<string>,
    issues_count: number,
    pull_requests_count: number,
    issues: Issue[],
    pull_requests: PullRequest[],
    downloads_total: number,
    downloads_last_30_days: number,
    created_at: string,
    updated_at: string,
    url: URL,
    debt_score: number,
    debt_score_graph: string,
    old_issues_count: number,
    old_pull_requests_count: number,
    hacktoberfestIssues: number,
    hasDownloads: boolean,
}
