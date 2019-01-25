import React from "react";

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
                <li className="breadcrumb-item active" aria-current="page">Metro - Guestbook</li>
                {this.props.isLoggedIn &&
                <button onClick={this.logout} type="button" className="btn btn-outline-secondary logout-btn">Log Out
                </button>}
            </ol>
        </nav>
    }
}

export default Header;