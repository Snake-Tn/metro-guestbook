import React from "react";

import EntryList from "./EntryList";
import CreateEntryForm from "./CreateEntryForm";
import {Redirect} from "react-router-dom";

class Wall extends React.Component {



    render() {
        if(!this.props.isLoggedIn){
            return <Redirect  to={{
                pathname: '/login',
                state: {destination: "/"}
            }}/>
        }
        return <div className="container">
            <CreateEntryForm/>
            <EntryList/>
        </div>
    }
}

export default Wall;