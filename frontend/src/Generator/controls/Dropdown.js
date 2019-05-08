import React, { Component } from "react";
import { Form, Dropdown } from "semantic-ui-react";
import { Field } from "formik";

let fieldCounter = 0;
class FormikDropdown extends Component {
  constructor(props) {
    super(props);
    this.id = props.id || `field_dropdown_${fieldCounter++}`;
  }

  render() {
    const {
      name,
      label,
      options,
      inputProps = {},
      fieldProps = {}
    } = this.props;
    return (
      <Field
        name={name}
        render={({ field, form }) => {
          const error = form.touched[name] && form.errors[name];
          return (
            <Form.Field error={!!error} {...fieldProps}>
              {!!label && (
                <label htmlFor={this.id} onClick={() => this._dropdown.open()}>
                  {label}
                </label>
              )}
              <Dropdown
                ref={el => (this._dropdown = el)}
                id={this.id}
                name={name}
                options={options}
                selectOnBlur={false}
                selectOnNavigation={false}
                selection
                {...inputProps}
                value={field.value}
                onChange={(e, { name, value }) => {
                  form.setFieldValue(name, value, true);
                }}
              />
              {form.errors[name] &&
                form.touched[name] && (
                  <span
                    style={{
                      display: "block",
                      margin: ".28571429rem 0",
                      color: "rgb(159, 58, 56)",
                      fontSize: ".92857143em"
                    }}
                  >
                    {form.errors[name]}
                  </span>
                )}
            </Form.Field>
          );
        }}
      />
    );
  }
}

export default FormikDropdown;
