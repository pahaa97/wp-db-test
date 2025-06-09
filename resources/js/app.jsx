import React, { useEffect, useState } from "react";
import { createRoot } from "react-dom/client";
import "antd/dist/reset.css";
import WpSitesList from "./components/WpSitesList";
import WpSitesPagination from "./components/WpSitesPagination";
import WpSiteFormModal from "./components/WpSiteFormModal";
import {
    getSites, getSite, createSite, updateSite, deleteSite, checkLogin
} from "./api/wpSites";
import { Button, message, Row, Col } from "antd";

const App = () => {
    const [sites, setSites] = useState([]);
    const [meta, setMeta] = useState({});
    const [loadingId, setLoadingId] = useState(null);
    const [deletingId, setDeletingId] = useState(null);
    const [modalOpen, setModalOpen] = useState(false);
    const [editingSite, setEditingSite] = useState(null);
    const [modalLoading, setModalLoading] = useState(false);
    const [currentPage, setCurrentPage] = useState(1);

    const fetchSites = async (page = 1) => {
        const res = await getSites(page);
        setSites(res.data.data);
        setMeta(res.data.meta || {});
        setCurrentPage(page);
    };

    useEffect(() => {
        fetchSites();
    }, []);

    const handleCheck = async (id) => {
        setLoadingId(id);
        try {
            await checkLogin(id);
            await fetchSites(currentPage);
            message.success("Login checked!");
        } catch (e) {
            message.error("Login check failed!");
        } finally {
            setLoadingId(null);
        }
    };

    const handleEdit = async (id) => {
        setModalLoading(true);
        try {
            const { data } = await getSite(id);
            setEditingSite(data.data);
            setModalOpen(true);
        } finally {
            setModalLoading(false);
        }
    };

    const handleDelete = async (id) => {
        setDeletingId(id);
        try {
            await deleteSite(id);
            await fetchSites(currentPage);
            message.success("Site deleted!");
        } catch {
            message.error("Failed to delete site!");
        } finally {
            setDeletingId(null);
        }
    };

    const handleAdd = () => {
        setEditingSite(null);
        setModalOpen(true);
    };

    const handleModalSubmit = async (values) => {
        setModalLoading(true);
        try {
            if (editingSite) {
                await updateSite(editingSite.id, values);
                message.success("Site updated!");
            } else {
                await createSite(values);
                message.success("Site created!");
            }
            setModalOpen(false);
            await fetchSites(currentPage);
        } catch (e) {
            message.error(
                e.response?.data?.message ||
                "Error. Please check your fields."
            );
        }
        setModalLoading(false);
    };

    const handlePageChange = (page) => fetchSites(page);

    return (
        <div style={{
            width: "100vw",
            minHeight: "100vh",
            background: "#fafafa",
            padding: 40
        }}>
            <Row justify="center">
                <Col xs={24} md={22} lg={20} xl={16}>
                    <div
                        style={{
                            background: "#fff",
                            borderRadius: 12,
                            padding: 24,
                            boxShadow: "0 2px 12px #0001",
                            minWidth: 400,
                            maxWidth: "100%",
                            margin: "0 auto"
                        }}
                    >
                        <div style={{
                            display: "flex",
                            alignItems: "center",
                            justifyContent: "space-between",
                            marginBottom: 24
                        }}>
                            <h2 style={{ margin: 0 }}>All sites</h2>
                            <Button type="primary" onClick={handleAdd}>
                                Add site
                            </Button>
                        </div>
                        <WpSitesList
                            sites={sites}
                            onCheck={handleCheck}
                            loadingId={loadingId}
                            onEdit={handleEdit}
                            onDelete={handleDelete}
                            deletingId={deletingId}
                        />
                        {meta && meta.total > meta.per_page && (
                            <WpSitesPagination meta={meta} onChange={handlePageChange} />
                        )}
                    </div>
                </Col>
            </Row>
            <WpSiteFormModal
                visible={modalOpen}
                onCancel={() => setModalOpen(false)}
                onSubmit={handleModalSubmit}
                initialValues={editingSite}
                loading={modalLoading}
            />
        </div>
    );
};

const root = createRoot(document.getElementById("root"));
root.render(<App />);
