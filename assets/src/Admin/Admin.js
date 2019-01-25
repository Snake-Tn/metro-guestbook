import React from "react";
import AdminEntryList from "./AdminEntryList"
import {Redirect} from "react-router-dom";

class Admin extends React.Component {

    render() {
        if (!this.props.isLoggedIn) {
            return <Redirect
                to={{
                    pathname: '/login',
                    state: {destination: "/admin"}
                }}
            />
        }
        return <div className="container">
            <AdminEntryList/>
        </div>
    }
}

export default Admin;