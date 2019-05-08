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
import { Form } from 'semantic-ui-react'
import { Dropdown, Input, } from './controls/index'

import { enumToOptions } from './semanticUiTools'

class ProjectOptions extends Component {
  render () {
    const properties = this.props.schema.properties

    if (properties === undefined) {
      return null
    }

    const appOptions     = properties.applicationOptions.properties
    const appTypeOptions = enumToOptions(appOptions.applicationType)

    return (
      <fieldset>
        <legend>Project options</legend>
        <Form.Group widths={'equal'}>
          <Input
            fluid
            name={'name'}
            label={properties.name.title}
            inputProps={{
              type: 'text',
              placeholder: properties.name.attr.placeholder,
            }}
          />
          <Input
            fluid
            name={'basePort'}
            label={properties.basePort.title}
            inputProps={{
              type: 'number',
            }}
          />
        </Form.Group>

        <Form.Group widths={'equal'}>
          <Dropdown
            name={'applicationOptions.applicationType'}
            label={appOptions.applicationType.title}
            options={appTypeOptions}

          />
          <Input
            name={'applicationOptions.uploadSize'}
            label={appOptions.uploadSize.title}
            inputProps={{
              type: 'number',
            }}
          />
        </Form.Group>
      </fieldset>
    )
  }
}

export default ProjectOptions
