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

    console.log(reduced)

    return reduced
  }
}



