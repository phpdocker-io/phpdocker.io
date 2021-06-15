<?php
/**
 * Copyright 2016 Luis Alberto Pabon Flores
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
namespace App\Entity\Generator;

use PHPDocker\Project\ServiceOptions\Elasticsearch;

/**
 * Elasticsearch options entity for validation.
 */
class ElasticsearchOptions extends Elasticsearch
{
    /**
     * @var string
     *
     * @Assert\NotBlank(groups={"elasticsearchOptions"})
     * @Assert\NotNull(groups={"elasticsearchOptions"})
     * @Assert\Length(min=1, max=128)
     */
    protected $version = self::VERSION_65;

    /**
     * Redirect hasElasticsearch to enabled.
     *
     * @param bool $hasElasticsearch
     *
     * @return self
     */
    public function setHasElasticsearch(bool $hasElasticsearch = false): self
    {
        return $this->setEnabled($hasElasticsearch);
    }

    /**
     * @return bool
     */
    public function hasElasticsearch(): bool
    {
        return $this->isEnabled();
    }
}
