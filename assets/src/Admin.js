import React from "react";
import EntryList from "./EntryList";
import {Redirect} from "react-router-dom";

class Admin extends React.Component {

    renderAdminEntryActions(props) {
        return <div className="admin-actions">
            <div className='raw'>
                <button type="button" className="btn btn-outline-success btn-block">Approve</button>
            </div>
            <div className='raw'>
                <button type="button" className="btn btn-outline-danger btn-block">Remove</button>
            </div>
            <div className='raw'>
                <button type="button" className="btn btn-outline-info btn-block">Edit</button>
            </div>

        </div>
    }

    isAdmin(){
        return localStorage.token;
    }

    render() {
        if(!this.isAdmin()){
            return <Redirect to="/"/>
        }
        return <div className="container">
            <EntryList extraComponent={this.renderAdminEntryActions} filter=""/>
        </div>
    }
}

export default Admin;