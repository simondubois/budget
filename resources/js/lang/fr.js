
export default {

    actions: {
        cancel: 'Annuler',
        confirm: 'Confirmer',
        delete: 'Supprimer',
        save: 'Enregistrer',
    },

    account: {
        name: 'Comptes',
        attributes: {
            allocations: 'Allocations',
            bank: 'Nom de la banque',
            cumulatedBalance: 'Solde cumulé',
            cumulatedSavings: 'Épargne cumulée',
            currencyIso: 'Devise du compte',
            expenses: 'Dépenses',
            incomes: 'Revenus',
            monthlyBalance: 'Solde mensuel',
            name: 'Nom du compte',
            periodBalance: 'Solde',
            periodSavings: 'Épargne',
        },
        all: {
            name: 'Tous les comptes',
            distribution: 'Répartition',
        },
        create: {
            name: 'Nouveau compte',
        },
        edit: {
            name: 'Modifier le compte',
        },
    },

    allocation: {
        name: 'Allocations',
    },

    currency: {
        name: 'Devises',
    },

    envelope: {
        name: 'Enveloppe',
        attributes: {
            allocations: 'Allocations',
            cumulatedBalance: 'Solde cumulé',
            defaultAllocation: 'Allocation mensuelle par défaut',
            defaultAllocationAmount: 'Montant',
            defaultAllocationCurrencyIso: 'Devise',
            expenses: 'Dépenses',
            icon: 'Icône l\'enveloppe',
            incomes: 'Revenus',
            monthlyBalance: 'Solde mensuel',
            name: 'Nom de l\'enveloppe',
            periodBalance: 'Solde',
        },
        all: {
            name: 'Toutes les enveloppes',
            distribution: 'Répartition',
        },
        create: {
            name: 'Nouvelle enveloppe',
        },
        edit: {
            name: 'Modifier l\'enveloppe',
        },
        figures: {
            name: 'Résultat {date}',
        },
        operations: {
            name: 'Opérations pour {date}',
            more: 'Toutes les opérations',
            empty: 'Cette envelope n\'a pas encore d\'opération ce mois-ci.',
        },
    },

    help: {
        onboarding: {
            account: 'Créer un compte bancaire.',
            currency: 'Enregistrer une devise.',
            defaultCurrency: 'Définir une devise par défaut.',
            envelope: 'Créer une envelope.',
            introduction: 'Dernières étapes pour configurer l\'application:',
        },
    },

    history: {
        period: {
            latest: 'Récent',
            monthly: 'Mensuel',
            yearly: 'Annuel',
        },
    },

    icons: {
        link: 'Rechercher une icône (en Anglais)',
        categories: {
            accessibility: 'Accessibilité',
            alert: 'Alertes',
            animals: 'Animaux',
            arrows: 'Flêches',
            'audio-video': 'Audio & Vidéo',
            automotive: 'Automobile',
            autumn: 'Automne',
            beverage: 'Boissons',
            buildings: 'Bâtiments',
            business: 'Affaires',
            camping: 'Camping',
            charity: 'Charité',
            chat: 'Chat',
            chess: 'Échecs',
            childhood: 'Enfance',
            clothing: 'Habits',
            code: 'Code',
            communication: 'Communication',
            computers: 'Ordinateurs',
            construction: 'Construction',
            currency: 'Devises',
            'date-time': 'Date & Heure',
            design: 'Design',
            editors: 'Éditeurs',
            education: 'Éducation',
            emoji: 'Emojis',
            energy: 'Énergie',
            files: 'Fichiers',
            finance: 'Finance',
            fitness: 'Fitness',
            food: 'Nourriture',
            'fruit-vegetable': 'Fruits & Légumes',
            games: 'Jeux',
            'gaming-tabletop': 'Jeux de société',
            gender: 'Genres',
            halloween: 'Halloween',
            hands: 'Mains',
            health: 'Santé',
            holiday: 'Vacances',
            hotel: 'Hôtel',
            household: 'Ménager',
            images: 'Images',
            interfaces: 'Interfaces',
            logistics: 'Logistique',
            maps: 'Orientation',
            maritime: 'Maritime',
            marketing: 'Marketing',
            mathematics: 'Mathematiques',
            medical: 'Médical',
            moving: 'Déménagement',
            music: 'Musique',
            objects: 'Objets',
            'payments-shopping': 'Paiement & Achats',
            pharmacy: 'Pharmacie',
            political: 'Politique',
            religion: 'Religion',
            science: 'Science',
            'science-fiction': 'Science Fiction',
            security: 'Securité',
            shapes: 'Formes',
            shopping: 'Shopping',
            social: 'Social',
            spinners: 'Centrifuge',
            sports: 'Sports',
            spring: 'Printemps',
            status: 'Statut',
            summer: 'Été',
            toggle: 'Interrupteurs',
            travel: 'Voyage',
            'users-people': 'Utilisateurs & Personnes',
            vehicles: 'Véhicles',
            weather: 'Météo',
            winter: 'Hiver',
            writing: 'Écriture',
        },
    },

    operation: {
        name: 'Opérations',
        all: {
            empty: 'Aucun opération ne correspond aux filtres de recherche.',
            paginationAll: 'Tout afficher',
            paginationMore: 'Afficher davantage',
            paginationTitle: '{per_page} opérations affichées sur {total}',
        },
        attributes: {
            amount: 'Montant',
            date: 'Date',
            fromAccountId: 'Compte débiteur',
            fromEnvelopeId: 'Envelope débitrice',
            name: 'Intitulé',
            toAccountId: 'Compte créditeur',
            toEnvelopeId: 'Envelope créditrice',
        },
        create: {
            name: 'Nouvelle opération',
            emptyToEnvelopeId: 'Non alloué',
        },
        duplicate: {
            name: 'Dupliquer l\'opération',
        },
        edit: {
            name: 'Modifier l\'opération',
            emptyToEnvelopeId: 'Non alloué',
        },
        filter: {
            allAccounts: 'Tous les comptes',
            allEnvelopes: 'Toutes les envelopes',
        },
        types: {
            allocation: 'Allocation mensuelle',
            expense: 'Dépense',
            income: 'Revenu',
            transfer: 'Virement bancaire',
        },
    },

};
