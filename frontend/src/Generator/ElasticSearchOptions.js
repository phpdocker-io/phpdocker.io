/*
 * Copyright 2020 Luis Alberto Pabón Flores
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
 *
 */

import React, { Component } from 'react'
import { Checkbox, Dropdown, } from './controls/index'
import { Form } from 'semantic-ui-react'

import { enumToOptions } from './semanticUiTools'

import { capitalize } from '../util'

class ElasticSearchOptions extends Component {
  render () {
    const properties = this.props.schema.properties
    const schemaNode = 'elasticsearchOptions'

    if (properties === undefined) {
      return null
    }

    const esOptions = properties[schemaNode]

    const name            = esOptions.title
    const enableFieldName = 'has' + capitalize(name.toLowerCase())
    const dbVersions      = enumToOptions(esOptions.properties.version)

    return (
      <fieldset>
        <legend>{name}</legend>
        <Form.Group>
          <Checkbox
            name={schemaNode + '.' + enableFieldName}
            label={esOptions.properties[enableFieldName].title}
            inputProps={{
              toggle: true,
            }}
          />
        </Form.Group>

        <Form.Group widths={'equal'}>
          <Dropdown
            name={schemaNode + '.version'}
            label={esOptions.properties.version.title}
            options={dbVersions}
            fieldProps={{
              required: true
            }}
          />
        </Form.Group>
      </fieldset>
    )
  }
}

export default ElasticSearchOptions
