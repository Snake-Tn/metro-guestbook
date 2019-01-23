import React, {Component} from 'react';
import {Router, Route, Redirect} from "react-router-dom";

import EntryList from './EntryList';
import Login from './Login';

import "./App.css";


class App extends Component {


    render() {
        return (
            <Router>
                <div>
                    <Route path="/" component={EntryList}/>

                </div>
            </Router>
        )
    }

}

export default App;
