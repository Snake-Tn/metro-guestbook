import React, {Component} from "react";
import {BrowserRouter as Router, Route, Redirect} from "react-router-dom";


import Wall from './Wall';
import Login from './Login';

import 'bootstrap/dist/css/bootstrap.min.css';
import "./App.css";
import Admin from "./Admin";
import Header from "./Header";
import Footer from "./Footer";

class App extends Component {
    render() {
        return <Router>
            <div>
                <Header/>
                <Route path="/" exact component={Wall}/>
                <Route path="/admin" exact component={Admin}/>
                <Route path="/login" exact component={Login}/>
                <Footer/>
            </div>
        </Router>
    }
}

export default App;

