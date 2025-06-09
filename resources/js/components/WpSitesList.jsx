import React from "react";
import { List, Button, Tag, Tooltip, Popconfirm } from "antd";
import { EditOutlined, DeleteOutlined } from "@ant-design/icons";

const statusMap = {
    true: { color: "green", text: "OK" },
    false: { color: "red", text: "Failed" },
    null: { color: "default", text: "Unknown" },
    undefined: { color: "default", text: "Unknown" }
};

const WpSitesList = ({
                         sites,
                         onCheck,
                         loadingId,
                         onEdit,
                         onDelete,
                         deletingId
                     }) => (
    <List
        itemLayout="horizontal"
        dataSource={sites}
        renderItem={site => {
            const status = statusMap[site.admin_login_is_valid];
            return (
                <List.Item
                    style={{
                        alignItems: "center",
                        borderBottom: "1px solid #f0f0f0"
                    }}
                    actions={[
                        <Button
                            size="small"
                            loading={loadingId === site.id}
                            disabled={loadingId === site.id}
                            onClick={() => onCheck(site.id)}
                            key="check"
                        >
                            Check login
                        </Button>,
                        <Button
                            size="small"
                            icon={<EditOutlined />}
                            onClick={() => onEdit(site.id)}
                            key="edit"
                        />,
                        <Popconfirm
                            title="Are you sure to delete this site?"
                            onConfirm={() => onDelete(site.id)}
                            okText="Delete"
                            cancelText="Cancel"
                            key="delete"
                        >
                            <Button
                                size="small"
                                icon={<DeleteOutlined />}
                                danger
                                loading={deletingId === site.id}
                                disabled={deletingId === site.id}
                            />
                        </Popconfirm>
                    ]}
                >
                    <List.Item.Meta
                        title={
                            <div style={{ display: "flex", alignItems: "center", gap: 12 }}>
                                <a href={site.site_url} target="_blank" rel="noopener noreferrer">{site.site_url}</a>
                                <Tooltip title={
                                    site.last_admin_login_check_at
                                        ? `Last check: ${new Date(site.last_admin_login_check_at).toLocaleString("en-GB")}`
                                        : "Never checked"
                                }>
                                    <Tag color={status.color}>{status.text}</Tag>
                                </Tooltip>
                            </div>
                        }
                        description={<a href={site.admin_url} target="_blank" rel="noopener noreferrer">{site.admin_url}</a>}
                    />
                </List.Item>
            );
        }}
    />
);

export default WpSitesList;
