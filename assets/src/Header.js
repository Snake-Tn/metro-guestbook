import React from "react";
import {Link } from "react-router-dom";
class Header extends React.Component {

    constructor(props) {
        super(props);
        this.logout = this.logout.bind(this);
    }

    logout() {
        this.props.setLoggedIn(false);
        localStorage.removeItem('token');
    }

    render() {
        return <nav aria-label="breadcrumb">
            <ol className="breadcrumb">

                <li className="breadcrumb-item active" aria-current="page"><Link to="/">Metro - Guestbook</Link></li>
                {this.props.isLoggedIn &&
                <button onClick={this.logout} type="button" className="btn btn-outline-secondary logout-btn">Log Out
                </button>}
            </ol>
        </nav>
    }
}

export default Header;