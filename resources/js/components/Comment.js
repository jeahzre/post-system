import axios from "axios";
import React, { useEffect, useState } from "react";
// import ReactDOM from "react-dom";

function Comment(props) {
  const { user, user_comment } = props || {};

  const { username } = user;
  const { comment, created_at, updated_at } = user_comment;
  return (
    <div className="p-2 border border-dark">
      <div className="d-flex">
        <strong className="pe-3">{username}</strong>
        <div>{comment}</div>
      </div>
      <time>{updated_at ? updated_at : created_at}</time>
    </div>
  );
}

export default Comment;
