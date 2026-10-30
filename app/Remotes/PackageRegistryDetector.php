<?php

namespace App\Remotes;

use App\Enums\PackageRegistry;
use App\Models\Project;
use App\Remotes\Npm\Search as NpmSearch;
use App\Remotes\Packagist\Search as PackagistSearch;

class PackageRegistryDetector
{
    /**
     * Work out which registry (if any) a project publishes to, and set the
     * matching name on the model. The caller is responsible for saving.
     *
     * Returns null when we couldn't reach a registry to find out, so a flaky
     * request never downgrades a project to "not a package".
     */
    public function detect(Project $project): ?PackageRegistry
    {
        // A name we already have is the most reliable signal, as long as the
        // registry still knows about it. Packagist names don't always match the
        // repo they're built from, so searching would miss them.
        if ($project->packagist_name) {
            $exists = PackagistSearch::packageExists($project->packagist_name);

            if (is_null($exists)) {
                return null;
            }

            if ($exists) {
                return $this->assign($project, PackageRegistry::Packagist, packagistName: $project->packagist_name);
            }
        }

        if ($project->npm_name) {
            $exists = NpmSearch::packageExists($project->npm_name);

            if (is_null($exists)) {
                return null;
            }

            if ($exists) {
                return $this->assign($project, PackageRegistry::Npm, npmName: $project->npm_name);
            }
        }

        $packagist = PackagistSearch::forPackageByRepo($project);

        if (! $packagist->searchOk) {
            return null;
        }

        if ($packagist->packagistName) {
            return $this->assign($project, PackageRegistry::Packagist, packagistName: $packagist->packagistName);
        }

        $npm = NpmSearch::forPackageByRepo($project);

        if (! $npm->searchOk) {
            return null;
        }

        if ($npm->npmName) {
            return $this->assign($project, PackageRegistry::Npm, npmName: $npm->npmName);
        }

        return $this->assign($project, PackageRegistry::None);
    }

    /**
     * Re-run detection from scratch, ignoring names we already have. Used when a
     * registry tells us the name we're holding doesn't exist there any more.
     */
    public function redetect(Project $project): ?PackageRegistry
    {
        $packagistName = $project->packagist_name;
        $npmName = $project->npm_name;

        $project->packagist_name = null;
        $project->npm_name = null;

        $registry = $this->detect($project);

        if (is_null($registry)) {
            // Couldn't find out; leave the project exactly as we found it.
            $project->packagist_name = $packagistName;
            $project->npm_name = $npmName;
        }

        return $registry;
    }

    protected function assign(Project $project, PackageRegistry $registry, ?string $packagistName = null, ?string $npmName = null): PackageRegistry
    {
        $project->package_registry = $registry;
        $project->packagist_name = $packagistName;
        $project->npm_name = $npmName;

        return $registry;
    }
}
