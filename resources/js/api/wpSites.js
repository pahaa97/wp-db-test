import axios from "axios";

export const getSites = (page = 1, perPage = 10) =>
    axios.get(`/api/v1/wp-sites?page=${page}&per_page=${perPage}`);

export const getSite = (id) =>
    axios.get(`/api/v1/wp-sites/${id}`);

export const createSite = (data) =>
    axios.post("/api/v1/wp-sites", data);

export const updateSite = (id, data) =>
    axios.put(`/api/v1/wp-sites/${id}`, data);

export const deleteSite = (id) =>
    axios.delete(`/api/v1/wp-sites/${id}`);

export const checkLogin = (id) =>
    axios.get(`/api/v1/wp-sites/${id}/check-admin`);
