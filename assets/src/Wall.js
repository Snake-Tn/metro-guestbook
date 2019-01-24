import React from "react";
import request from "request-promise";

import EntryList from "./EntryList";
import CreateEntryForm from "./CreateEntryForm";
import {Redirect} from "react-router-dom";

class Wall extends React.Component {

    isLoggedIn(){
        return localStorage.token;
    }

    render() {
        if(!this.isLoggedIn()){
            return <Redirect to="/login"/>
        }
        return <div className="container">
            <CreateEntryForm/>
            <EntryList/>
        </div>
    }
}

export default Wall;