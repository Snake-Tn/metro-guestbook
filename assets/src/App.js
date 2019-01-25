import React, {Component} from "react";
import {BrowserRouter as Router, Route} from "react-router-dom";


import Wall from './Wall/Wall';
import Login from './Login';

import 'bootstrap/dist/css/bootstrap.min.css';
import "./App.css";
import Admin from "./Admin/Admin";
import Header from "./Header";
import Footer from "./Footer";

class App extends Component {

    constructor(props) {
        super(props);
        this.state = {isLoggedIn: (typeof localStorage.token !== 'undefined')};
        this.setLoggedIn = this.setLoggedIn.bind(this);
    }

    setLoggedIn(isLoggedIn) {
        this.setState({isLoggedIn: isLoggedIn});
    }

    render() {
        return <Router>
            <div>
                <Header isLoggedIn={this.state.isLoggedIn} setLoggedIn={this.setLoggedIn}/>
                <Route path="/" exact
                       render={() => <Wall isLoggedIn={this.state.isLoggedIn}/>}
                />
                <Route path="/admin" exact
                       render={() => <Admin isLoggedIn={this.state.isLoggedIn}/>}
                />
                <Route path="/login" exact
                       render={() => <Login isLoggedIn={this.state.isLoggedIn} setLoggedIn={this.setLoggedIn}/>}
                />
                <Footer/>
            </div>
        </Router>
    }
}

export default App;

