/*
 * Copyright 2019 Luis Alberto Pabón Flores
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
import { Checkbox, Dropdown, Input, } from './controls/index'
import { Form } from 'semantic-ui-react'

import { enumToOptions, getPlaceholder } from './semanticUiTools'

import { capitalize } from '../util'

class MySQLCompatibleOptions extends Component {
  render () {
    const properties = this.props.schema.properties
    const schemaNode = this.props.schemaNode

    if (properties === undefined) {
      return null
    }

    const dbOptions = properties[schemaNode]

    const name            = dbOptions.title
    const enableFieldName = 'has' + capitalize(name.toLowerCase())
    const dbVersions      = enumToOptions(dbOptions.properties.version)

    return (
      <fieldset>
        <legend>{name}</legend>
        <Form.Group>
          <Checkbox
            name={schemaNode + '.' + enableFieldName}
            label={dbOptions.properties[enableFieldName].title}
            inputProps={{
              toggle: true,
            }}
          />
        </Form.Group>

        <Form.Group widths={'equal'}>
          <Dropdown
            name={schemaNode + '.version'}
            label={dbOptions.properties.version.title}
            options={dbVersions}
            fieldProps={{
              required: true
            }}
          />
          <Input
            name={schemaNode + '.rootPassword'}
            label={getPlaceholder(dbOptions.properties.rootPassword)}
            fieldProps={{
              required: true
            }}
          />
        </Form.Group>
        <Form.Group widths={'equal'}>
          <Input
            name={schemaNode + '.databaseName'}
            label={getPlaceholder(dbOptions.properties.databaseName)}
            fieldProps={{
              required: true
            }}
          />
          <Input
            name={schemaNode + '.username'}
            label={getPlaceholder(dbOptions.properties.username)}
            fieldProps={{
              required: true
            }}
          />
          <Input
            name={schemaNode + '.password'}
            label={getPlaceholder(dbOptions.properties.password)}
            fieldProps={{
              required: true
            }}
          />
        </Form.Group>
      </fieldset>
    )
  }
}

export default MySQLCompatibleOptions
