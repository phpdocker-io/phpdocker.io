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

module.exports = {
  /**
   * Given a JSON schema enum property, return a list of objects that can be sent to semantic-ui options (eg for
   * dropdown or multi selects).
   *
   * @param enumProperty The JSON schema node that contains the enum property.
   * @returns {Array}
   */
  enumToOptions: enumProperty => {
    const enumValues = enumProperty.enum
    const enumTitles = enumProperty.enum_titles

    if (enumValues === undefined || Array.isArray(enumValues) === false) {
      throw new Error('enumProperty contains no enum list')
    }

    if (enumTitles === undefined || Array.isArray(enumTitles) === false) {
      throw new Error('enumProperty contains no enum_titles list')
    }

    const reduced = []
    for (let i = 0; i < enumValues.length; i++) {
      reduced[i] = {
        key: enumValues[i],
        value: enumValues[i],
        text: enumTitles[i],
      }

      reduced[enumValues[i]] = enumTitles[i]
    }

    return reduced
  },

  /**
   * Given a json schema property node, return the value of the placeholder (if any).
   *
   * @param property {object}
   * @returns {string}
   */
  getPlaceholder: property => {
    return property.attr.placeholder || ''
  }
}
