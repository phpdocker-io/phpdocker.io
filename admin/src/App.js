import React from 'react';
import {RichTextField} from 'react-admin';
import RichTextInput from 'ra-input-rich-text';
import {HydraAdmin} from '@api-platform/admin';
import parseHydraDocumentation from '@api-platform/api-doc-parser/lib/hydra/parseHydraDocumentation';

const entrypoint = process.env.REACT_APP_API_ENTRYPOINT;

const myApiDocumentationParser = entrypoint => parseHydraDocumentation(entrypoint)
    .then(({api}) => {
        const posts = api.resources.find(({name}) => 'posts' === name);
        const body  = posts.fields.find(f => 'body' === f.name);
        const bodyIntro  = posts.fields.find(f => 'bodyIntro' === f.name);

        body.input = props => (
            <RichTextInput {...props} source="body"/>
        );

        bodyIntro.input = props => (
            <RichTextInput {...props} source="bodyIntro"/>
        );

        const defaultProps = {
            addField: true,
            addLabel: true
        };

        body.input.defaultProps = defaultProps;
        bodyIntro.input.defaultProps = defaultProps;

        return {api};
    })
;

export default (props) => <HydraAdmin apiDocumentationParser={myApiDocumentationParser} entrypoint={entrypoint}/>;
