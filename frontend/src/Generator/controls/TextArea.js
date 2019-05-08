import React, { Component } from "react";
import { Form, TextArea } from "semantic-ui-react";
import { Field } from "formik";

let fieldCounter = 0;
class FormikTextArea extends Component {
  constructor(props) {
    super(props);
    this.id = props.id || `field_textarea_${fieldCounter++}`;
  }

  render() {
    const { name, label, inputProps = {}, fieldProps = {} } = this.props;
    return (
      <Field
        name={name}
        render={({ field, form }) => {
          const error = form.touched[name] && form.errors[name];
          return (
            <Form.Field error={!!error} {...fieldProps}>
              {!!label && <label htmlFor={this.id}>{label}</label>}
              <TextArea
                id={this.id}
                name={name}
                value={field.value}
                onChange={(e, { name, value }) => {
                  form.setFieldValue(name, value, true);
                }}
                rows={4}
                {...inputProps}
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

export default FormikTextArea;
