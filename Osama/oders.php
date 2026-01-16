<div class="orders-page">
    <div class="page-header">
        <h1>
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="3" width="18" height="18" rx="2"/>
                <path d="M9 3v18"/>
            </svg>
            Commandes
        </h1>
        <a href="index.php?page=admin_orders&show=all" class="btn-see-all">
            Voir tout
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M5 12h14M12 5l7 7-7 7"/>
            </svg>
        </a>
    </div>

    <!-- Filtres -->
    <div class="orders-filters">
        <div class="filter-item active">
            <span>En cours</span>
            <span class="badge badge-green"><?= count($currentOrders) ?></span>
        </div>
        <div class="filter-item">
            <span>5 prochains jours</span>
            <span class="badge badge-blue"><?= count($upcomingOrders) ?></span>
        </div>
    </div>

    <!-- Liste des commandes en cours -->
    <div class="orders-list">
        <?php if (empty($currentOrders)): ?>
            <div class="empty-state">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                    <path d="M9 3v18"/>
                </svg>
                <p>Aucune commande en cours</p>
            </div>
        <?php else: ?>
            <?php foreach ($currentOrders as $order): ?>
                <div class="order-card">
                    <div class="order-header">
                        <div class="order-id">
                            <strong>#<?= str_pad($order['id_reservation'], 7, '0', STR_PAD_LEFT) ?></strong>
                            <span class="vehicle-info">• <?= htmlspecialchars($order['marque'] . ' ' . $order['modele']) ?></span>
                        </div>
                        <div class="order-badges">
                            <span class="badge-plate"><?= htmlspecialchars($order['plaque']) ?></span>
                            <span class="badge badge-green">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                </svg>
                                En utilisation
                            </span>
                        </div>
                    </div>

                    <div class="order-details">
                        <div class="detail-row">
                            <div class="detail-label">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                                <span>Client</span>
                            </div>
                            <span class="detail-value"><?= htmlspecialchars($order['client_nom']) ?></span>
                        </div>

                        <div class="detail-row">
                            <div class="detail-label">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                </svg>
                                <span>Contact</span>
                            </div>
                            <span class="detail-value"><?= htmlspecialchars($order['client_email']) ?></span>
                        </div>

                        <div class="detail-row">
                            <div class="detail-label">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                    <line x1="16" y1="2" x2="16" y2="6"/>
                                    <line x1="8" y1="2" x2="8" y2="6"/>
                                    <line x1="3" y1="10" x2="21" y2="10"/>
                                </svg>
                                <span>Échéance</span>
                            </div>
                            <span class="detail-value"><?= date('d F Y', strtotime($order['date_fin'])) ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <!-- Commandes à venir -->
        <?php if (!empty($upcomingOrders)): ?>
            <div class="section-divider">
                <h3>Prochaines réservations</h3>
            </div>
            <?php foreach ($upcomingOrders as $order): ?>
                <div class="order-card upcoming">
                    <div class="order-header">
                        <div class="order-id">
                            <strong>#<?= str_pad($order['id_reservation'], 7, '0', STR_PAD_LEFT) ?></strong>
                            <span class="vehicle-info">• <?= htmlspecialchars($order['marque'] . ' ' . $order['modele']) ?></span>
                        </div>
                        <div class="order-badges">
                            <span class="badge-plate"><?= htmlspecialchars($order['plaque']) ?></span>
                            <span class="badge badge-blue">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/>
                                    <polyline points="12 6 12 12 16 14"/>
                                </svg>
                                Dans <?= $order['jours_avant'] ?> jour(s)
                            </span>
                        </div>
                    </div>

                    <div class="order-details">
                        <div class="detail-row">
                            <div class="detail-label">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                                <span>Client</span>
                            </div>
                            <span class="detail-value"><?= htmlspecialchars($order['client_nom']) ?></span>
                        </div>

                        <div class="detail-row">
                            <div class="detail-label">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                    <line x1="16" y1="2" x2="16" y2="6"/>
                                    <line x1="8" y1="2" x2="8" y2="6"/>
                                    <line x1="3" y1="10" x2="21" y2="10"/>
                                </svg>
                                <span>Date de début</span>
                            </div>
                            <span class="detail-value"><?= date('d F Y', strtotime($order['date_debut'])) ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<style>
* {
    box-sizing: border-box;
}

.orders-page {
    padding: 32px;
    max-width: 1400px;
    margin: 0 auto;
    background: #f8fafc;
    min-height: 100vh;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
}

/* Header */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 32px;
    animation: fadeInDown 0.5s ease;
}

.page-header h1 {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 28px;
    font-weight: 700;
    color: #0f172a;
    margin: 0;
}

.page-header h1 svg {
    color: #10b981;
    filter: drop-shadow(0 2px 4px rgba(16, 185, 129, 0.2));
}

.btn-see-all {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    color: #64748b;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

.btn-see-all:hover {
    background: #f8fafc;
    border-color: #cbd5e1;
    transform: translateY(-1px);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
}

/* Filtres */
.orders-filters {
    display: flex;
    gap: 16px;
    margin-bottom: 28px;
    animation: fadeIn 0.6s ease;
}

.filter-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 24px;
    background: white;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    font-weight: 500;
    color: #475569;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

.filter-item.active {
    background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
    border-color: #10b981;
    color: #065f46;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.15);
}

.filter-item:hover:not(.active) {
    border-color: #cbd5e1;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
}

/* Badges */
.badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: 0.3px;
}

.badge-green {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: #065f46;
    box-shadow: 0 2px 8px rgba(16, 185, 129, 0.2);
}

.badge-blue {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    color: #1e40af;
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.2);
}

/* Liste des commandes */
.orders-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
    animation: fadeInUp 0.7s ease;
}

.order-card {
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 24px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    position: relative;
    overflow: hidden;
}

.order-card::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
    background: linear-gradient(180deg, #10b981 0%, #059669 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.order-card:hover::before {
    opacity: 1;
}

.order-card:hover {
    border-color: #cbd5e1;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    transform: translateY(-4px);
}

.order-card.upcoming::before {
    background: linear-gradient(180deg, #3b82f6 0%, #2563eb 100%);
}

/* Header de la carte */
.order-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 20px;
    padding-bottom: 20px;
    border-bottom: 1px solid #f1f5f9;
}

.order-id {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.order-id strong {
    font-size: 18px;
    color: #0f172a;
    font-weight: 700;
}

.vehicle-info {
    color: #64748b;
    font-size: 15px;
    font-weight: 500;
}

.order-badges {
    display: flex;
    gap: 10px;
    align-items: center;
    flex-wrap: wrap;
}

.badge-plate {
    padding: 6px 14px;
    background: #f1f5f9;
    border: 1.5px solid #cbd5e1;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700;
    color: #334155;
    letter-spacing: 0.5px;
    font-family: 'Courier New', monospace;
}

/* Détails de la commande */
.order-details {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 16px;
    background: #f8fafc;
    border-radius: 10px;
    transition: all 0.2s ease;
}

.detail-row:hover {
    background: #f1f5f9;
}

.detail-label {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #64748b;
    font-size: 14px;
    font-weight: 500;
}

.detail-label svg {
    color: #94a3b8;
}

.detail-value {
    color: #0f172a;
    font-weight: 600;
    font-size: 14px;
}

/* Section divider */
.section-divider {
    margin: 32px 0 24px;
    padding: 16px 0;
    border-top: 2px solid #e2e8f0;
}

.section-divider h3 {
    font-size: 20px;
    color: #334155;
    font-weight: 700;
    margin: 0;
}

/* État vide */
.empty-state {
    text-align: center;
    padding: 64px 24px;
    color: #94a3b8;
    background: white;
    border-radius: 16px;
    border: 2px dashed #e2e8f0;
}

.empty-state svg {
    margin: 0 auto 16px;
    color: #cbd5e1;
    opacity: 0.5;
}

.empty-state p {
    font-size: 16px;
    font-weight: 500;
    margin: 0;
}

/* Animations */
@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive */
@media (max-width: 768px) {
    .orders-page {
        padding: 20px;
    }
    
    .page-header {
        flex-direction: column;
        gap: 16px;
        align-items: flex-start;
    }
    
    .page-header h1 {
        font-size: 24px;
    }
    
    .orders-filters {
        flex-direction: column;
    }
    
    .filter-item {
        width: 100%;
    }
    
    .order-header {
        flex-direction: column;
        gap: 16px;
    }
    
    .order-badges {
        width: 100%;
    }
    
    .detail-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
}

@media (max-width: 480px) {
    .orders-page {
        padding: 16px;
    }
    
    .order-card {
        padding: 16px;
    }
    
    .page-header h1 {
        font-size: 20px;
    }
}
</style>
