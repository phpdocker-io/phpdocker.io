import React, { Component } from 'react';
import { HydraAdmin } from '@api-platform/admin';

class App extends Component {
    render() {
        return <HydraAdmin entrypoint="https://demo.api-platform.com"/> // Replace with your own API entrypoint
    }
}

export default App;
