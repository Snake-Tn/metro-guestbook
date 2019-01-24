import React from "react";

class Header extends React.Component {

    render() {
        return <nav aria-label="breadcrumb">
            <ol className="breadcrumb">
                <li className="breadcrumb-item active" aria-current="page">Metro - Guestbook</li>
            </ol>
        </nav>
    }
}

export default Header;